<?php
date_default_timezone_set('Europe/London');
include('conn.php');
include('func/Converter.php');
$apiResponse  = array('response_code' => '','response_data' => '','response_msg' => '');

if($_SERVER['REQUEST_METHOD'] == 'POST') {

	$promo_id = trim($_POST['promo_id']);
	$device_id = trim($_POST['device_id']);

	// get server details
	$serverLocation = Converter::get_server_location();
	$ser_lat = $serverLocation['latitude'];
	$ser_lng = $serverLocation['longitude'];

	// get server offset
	$server_offset = Converter::get_time_zone($ser_lat, $ser_lng);
	// $apiResponse['ser_off'] = $server_offset;

	// get pref coupon
	$get_pref_coupon = "SELECT * FROM `coupons` WHERE `promo_id`=" . $promo_id . " AND (coupon_availabilty > count_occupied OR coupon_availabilty = 'Unlimited') ORDER BY coupon_id ASC LIMIT 0,1";
	$exec = $dbh->query($get_pref_coupon);
	$pref_coupon = $exec->fetchAll(PDO::FETCH_OBJ);
	$rowsPref = $exec->rowCount();

	// $apiResponse['pref'] = $pref_coupon;

	// get store id
	$get_store_id = "SELECT * FROM `promo_locations` WHERE `promo_id`=" . $promo_id ." LIMIT 0,1";
	$ecex = $dbh->query($get_store_id);
	$details = $ecex->fetchAll(PDO::FETCH_OBJ);

	$store_id = $details[0]->store_id;

	// get store lat lng 
	$get_lat_lng = "SELECT * FROM `places` WHERE `place_id`=" . $store_id;
	$excGetST = $dbh->query($get_lat_lng);
	$getDet = $excGetST->fetchAll(PDO::FETCH_OBJ);

	$store_lat = $getDet[0]->latitude;
	$store_lng = $getDet[0]->longitude;

	// get store offset 
	$store_offset = Converter::get_time_zone($store_lat, $store_lng);
	// $apiResponse['store_off'] = $store_offset;

	if($rowsPref > 0) {
		// get coupon details
		$pref_coup_id= $pref_coupon[0]->coupon_id;
		$pref_coupon_lvl = $pref_coupon[0]->coupon_level; 

		// check if this has saved 
		$chkSaved = "SELECT * FROM `user_coupons` WHERE `scan_coupon_id`=" . $pref_coup_id . " And `device_id`='" . $device_id . "' AND ((`scan_coupon_status`=2) OR (`scan_coupon_status`=4))";
		$excSvd = $dbh->query($chkSaved);
		$svdRows = $excSvd->rowCount();

		if($svdRows > 0) {
			// if user has saved and expired
			// find next best coupon 
			// get all other coupons
			$get_other_coupons = "SELECT * FROM `coupons` WHERE `promo_id`=" . $promo_id;
			$execAll = $dbh->query($get_other_coupons);
			$all_coupons = $execAll->fetchAll(PDO::FETCH_OBJ);
			$rowsAll = $execAll->rowCount();

			if($pref_coupon_lvl < 4) {
				for($x = $pref_coupon_lvl; $x < 4; $x++) {
					// next coupon id
					$t_n_coupon_id = $all_coupons[$x]->coupon_id;
					$t_availability = $all_coupons[$x]->coupon_availabilty;
					$t_occuepied = $all_coupons[$x]->count_occupied;

					// check availability 
					if(($t_availability > $t_occuepied) || ($t_availability == "Unlimited")) {
						// if available
						// check for saved 
						$chkSaved2 = "SELECT * FROM `user_coupons` WHERE `scan_coupon_id`=" . $t_n_coupon_id . " And `device_id`='" . $device_id . "'";
						$excSvd2 = $dbh->query($chkSaved2);
						$svdRows2 = $excSvd2->rowCount();

						if($svdRows2 > 0) {
							// if user has saved
							continue;
						} 
						else {
							// if coupon hasn't saved
							// check for exclude 
							// check if this lvl excluded
							$checkExcluded = "SELECT * FROM `exclued_coupons` WHERE `device_id`='" . $device_id . "' AND `coupon_id`=" . $t_n_coupon_id . " ORDER BY `id` ASC";
							$executeCkeck = $dbh->query($checkExcluded);
							$rowsCheck = $executeCkeck->rowCount();
							$resExcludeCheck = $executeCkeck->fetchAll(PDO::FETCH_OBJ);

							if($rowsCheck > 0) {
								// if excluded 
								// check date
								// check last excluded time 
								$get_last_n  =  ($resExcludeCheck[$rowsCheck - 1]->created_at);
								$last_n = strtotime($get_last_n . " 23:59:00");
	
								// get server time 
								$serverTime_n = Converter::get_server_time_by_store_time($last_n, $store_offset, $server_offset);
	
								// now 
								$today_n = date('Y-m-d H:i:s');
	
								// create date objects 
								$serverDateObjN = date_create($serverTime_n);
								$todayDateObjN = date_create($today_n);
								
								$diffPref_n = date_diff($serverDateObjN, $todayDateObjN);
								$is_passed_n = 0;
	
								// check time difference 
								if(sizeof($diffPref_n) > 0){
									if($diffPref_n->invert == 0){
										$get_time_difference = ((((($diffPref_n->y * 365.25 + $diffPref_n->m * 30 + $diffPref_n->d) * 24 + $diffPref_n->h) * 60 + $diffPref_n->i) * 60 + $diffPref_n->s) * 1000);
	
										if($get_time_difference > 0) {
											$is_passed = 1;
										}
									}
								}

								if($is_passed = 1) {
									// if exclude expired
									$apiResponse['response_code'] = 200;
									$apiResponse['response_data'] = ['coupon_id' => $t_n_coupon_id ];
									$apiResponse['response_msg'] = "Next available coupon";
									break;
								}
								else {
									// if still excluded
									continue;
								}

							}
							else {
								// return id
								$apiResponse['response_code'] = 200;
								$apiResponse['response_data'] = ['coupon_id' => $t_n_coupon_id ];
								$apiResponse['response_msg'] = "Next available coupon";
								break;
							}

						}

					}
					else {
						// if not available
						continue;
					}

				}
			}
			else {
				// if pref not available
				$apiResponse['response_code'] = 200;
				$apiResponse['response_data'] = ['coupon_id' => $pref_coup_id ];
				$apiResponse['response_msg'] = "Next available coupon";
			}
		}
		else {
			// if user hasn't saved this coupon 
			// check if pref coupon is excluded 
			$chkPrefExclude = "SELECT * FROM `exclued_coupons` WHERE `device_id`='" . $device_id . "' AND `coupon_id`=" . $pref_coup_id . " ORDER BY `id` ASC";
			$exctChkPrefExclude = $dbh->query($chkPrefExclude);
			$rowsPrefExclude = $exctChkPrefExclude->rowCount();
			$prefExcleded = $exctChkPrefExclude->fetchAll(PDO::FETCH_OBJ);

			if($rowsPrefExclude > 0) {
				// if excluded
				// get last exclude
				$get_last  =  ($prefExcleded[$rowsPrefExclude - 1]->date);
				$lastDate = strtotime($get_last . " 23:59:00");

				// get server time 
				$serverTime = Converter::get_server_time_by_store_time($lastDate, $store_offset, $server_offset);

				// now 
				$today = date('Y-m-d H:i:s');

				// create date objects 
				$serverDateObj = date_create($serverTime);
				$todayDateObj = date_create($today);
				
				$diffPref = date_diff($serverDateObj, $todayDateObj);
				$is_passed = 0;

				// check time difference 
				if(sizeof($diffPref) > 0){
					if($diffPref->invert == 0){
						$get_time_difference = ((((($diffPref->y * 365.25 + $diffPref->m * 30 + $diffPref->d) * 24 + $diffPref->h) * 60 + $diffPref->i) * 60 + $diffPref->s) * 1000);

						if($get_time_difference > 0) {
							$is_passed = 1;
						}
					}
				}

				if($is_passed == 1) {
					// if exclude expired 
					$apiResponse['response_code'] = 200;
					$apiResponse['response_data'] = ['coupon_id' => $pref_coup_id ];
					$apiResponse['response_msg'] = "Next available coupon";
				} 
				else {
					// if exclude not expired 
					// find next best coupon 
					// get all other coupons
					$get_other_coupons = "SELECT * FROM `coupons` WHERE `promo_id`=" . $promo_id;
					$execAll = $dbh->query($get_other_coupons);
					$all_coupons = $execAll->fetchAll(PDO::FETCH_OBJ);
					$rowsAll = $execAll->rowCount();

					if($pref_coupon_lvl < 4) {
						for($x = $pref_coupon_lvl; $x < 4; $x++) {
							// next coupon id



							$t_n_coupon_id = $all_coupons[$x]->coupon_id;
							$t_availability = $all_coupons[$x]->coupon_availabilty;
							$t_occuepied = $all_coupons[$x]->count_occupied;


							// check availability 
							if(($t_availability > $t_occuepied) || ($t_availability == "Unlimited")) {
								// if available
								// check for saved 
								$chkSaved2 = "SELECT * FROM `user_coupons` WHERE `scan_coupon_id`=" . $t_n_coupon_id . " And `device_id`='" . $device_id . "' AND ((`scan_coupon_status`=2) OR (`scan_coupon_status`=4))";
								$excSvd2 = $dbh->query($chkSaved2);
								$svdRows2 = $excSvd2->rowCount();

								if($svdRows2 > 0) {
									// if user has saved
									continue;
								} 
								else {
									// if coupon hasn't saved
									// check for exclude 
									// check if this lvl excluded
									$checkExcluded = "SELECT * FROM `exclued_coupons` WHERE `device_id`='" . $device_id . "' AND `coupon_id`=" . $t_n_coupon_id . " ORDER BY `id` ASC";
									$executeCkeck = $dbh->query($checkExcluded);
									$rowsCheck = $executeCkeck->rowCount();
									$resExcludeCheck = $executeCkeck->fetchAll(PDO::FETCH_OBJ);

									if($rowsCheck > 0) {
										// if excluded 
										// check date
										// check last excluded time 
										$get_last_n  =  ($resExcludeCheck[$rowsCkeck - 1]->created_at);
										$last_n = strtotime($get_last_n . " 23:59:00");
			
										// get server time 
										$serverTime_n = Converter::get_server_time_by_store_time($last_n, $store_offset, $server_offset);
			
										// now 
										$today_n = date('Y-m-d H:i:s');
			
										// create date objects 
										$serverDateObjN = date_create($serverTime_n);
										$todayDateObjN = date_create($today_n);
										
										$diffPref_n = date_diff($serverDateObjN, $todayDateObjN);
										$is_passed_n = 0;
			
										// check time difference 
										if(sizeof($diffPref_n) > 0){
											if($diffPref_n->invert == 0){
												$get_time_difference_n = ((((($diffPref_n->y * 365.25 + $diffPref_n->m * 30 + $diffPref_n->d) * 24 + $diffPref_n->h) * 60 + $diffPref_n->i) * 60 + $diffPref_n->s) * 1000);
			
												if($get_time_difference_n > 0) {
                                                    $is_passed_n = 1;
												}
											}
										}

										if($is_passed_n == 1) {
											// if exclude expired
											$apiResponse['response_code'] = 200;
											$apiResponse['response_data'] = ['coupon_id' => $t_n_coupon_id ];
											$apiResponse['response_msg'] = "Next available coupon";
											break;
										}
										else {
											// if still excluded
											continue;
										}

									}
									else {
										// return id
										$apiResponse['response_code'] = 200;
										$apiResponse['response_data'] = ['coupon_id' => $t_n_coupon_id ];
										$apiResponse['response_msg'] = "Next available coupon";
										break;
									}

								}

							}
							else {
								// if not available
								continue;
							}

						}
					}
					else {
                        $apiResponse['extra'][] = "cp level == 4";
						// if pref not available
						$apiResponse['response_code'] = 200;
						$apiResponse['response_data'] = ['coupon_id' => $pref_coup_id ];
						$apiResponse['response_msg'] = "Next available coupon";
					}

				}


			}
			else {

                $apiResponse['extra'][] = "exclude == 0";
				// if not excluded 
				$apiResponse['response_code'] = 200;
				$apiResponse['response_data'] = ['coupon_id' => $pref_coup_id ];
				$apiResponse['response_msg'] = "Next available coupon";
			}

		}

	}
	else {
		// if pref not available
		$apiResponse['response_code'] = 200;
		$apiResponse['response_data'] = [];
		$apiResponse['response_msg'] = "No Coupons are available";
	}
}

header('Content-Type: application/json');
echo json_encode($apiResponse);