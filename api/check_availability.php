<?php
include('conn.php');
$apiResponse  = array('response_code' => '','response_data' => '','response_msg' => '');

if($_SERVER['REQUEST_METHOD'] == 'POST') {

	$promo_id = trim($_POST['promo_id']);
	$device_id = trim($_POST['device_id']);

	// get pref coupon
	$get_pref_coupon = "SELECT * FROM `coupons` WHERE `promo_id`=" . $promo_id . " AND (coupon_availabilty > count_occupied OR coupon_availabilty = 'Unlimited') ORDER BY coupon_id ASC LIMIT 0,1";
	$exec = $dbh->query($get_pref_coupon);
	$pref_coupon = $exec->fetchAll(PDO::FETCH_OBJ);
	$rowsPref = $exec->rowCount();
	

	if($rowsPref > 0) {
		
		// get coupon details
		$pref_coup_id= $pref_coupon[0]->coupon_id;
		$pref_coupon_lvl = $pref_coupon[0]->coupon_level; 

		// check if pref coupon is excluded 
		$chkPrefExclude = "SELECT * FROM `exclued_coupons` WHERE `device_id`='" . $device_id . "' AND `coupon_id`=" . $pref_coup_id . " ORDER BY `id` ASC";
		$exctChkPrefExclude = $dbh->query($chkPrefExclude);
		$rowsPrefExclude = $exctChkPrefExclude->rowCount();
		$prefExcleded = $exctChkPrefExclude->fetchAll(PDO::FETCH_OBJ);
		
		
		if($rowsPrefExclude > 0) {
			// if coupon has exclude 
			// check time 
			// get last exclude
			$get_last  =  date($prefExcleded[$rowsPrefExclude - 1]->created_at);

			$last_date = date_create($get_last);

			$get_now = date('Y-m-d H:i:s');
			// add one hour
			$get_now2 = date('Y-m-d H:i:s', strtotime($now . "+1 hour"));
			$get_today = date_create($get_now2);

			$getTimeDiff = date_diff($last_date, $get_today);

			$get_time_difference = 0;
		
			if(sizeof($getTimeDiff) > 0 ) {

				if ($getTimeDiff->invert == 0) {
					$get_time_difference = ((((($getTimeDiff->y * 365.25 + $getTimeDiff->m * 30 + $getTimeDiff->d) * 24 + $getTimeDiff->h) * 60 + $getTimeDiff->i) * 60 + $getTimeDiff->s) * 1000);
				}
			}

			if(($get_time_difference > 0) && ($get_time_difference <= 86400000)) {
				
				// get all other coupons
				$get_other_coupons = "SELECT * FROM `coupons` WHERE `promo_id`=" . $promo_id;
				$execAll = $dbh->query($get_other_coupons);
				$all_coupons = $execAll->fetchAll(PDO::FETCH_OBJ);
				$rowsAll = $execAll->rowCount();

				for($x = $pref_coupon_lvl; $x < 4; $x++) {

					// next coupon id
					$t_n_coupon_id = $all_coupons[$x]->coupon_id;
					$t_availability = $all_coupons[$x]->coupon_availabilty;
					$t_occuepied = $all_coupons[$x]->count_occupied;

					if(($t_availability > $t_occuepied) || ($t_availability == "Unlimited")) {
						// if coupon available 
						// check for exclude 
						// check if this lvl excluded
                        $checkExcluded = "SELECT * FROM `exclued_coupons` WHERE `device_id`='" . $device_id . "' AND `coupon_id`=" . $t_n_coupon_id . " ORDER BY `id` ASC";
                        $executeCkeck = $dbh->query($checkExcluded);
                        $rowsCkeck = $executeCkeck->rowCount();
						$resExcludeCheck = $executeCkeck->fetchAll(PDO::FETCH_OBJ);
						
						if($rowsCkeck > 0) {
							// if exclude 
							// get last exclude
                            $get_last  =  date($resExcludeCheck[$rowsCkeck - 1]->created_at);

                            $last_date = date_create($get_last);

                            $get_now = date('Y-m-d H:i:s');
                            // add one hour
                            $get_now2 = date('Y-m-d H:i:s', strtotime($now . "+1 hour"));
                            $get_today = date_create($get_now2);

                            $getTimeDiff = date_diff($last_date, $get_today);

                            $get_time_difference = 0;

                            if(sizeof($getTimeDiff) > 0 ) {

                                if ($getTimeDiff->invert == 0) {
                                    $get_time_difference = ((((($getTimeDiff->y * 365.25 + $getTimeDiff->m * 30 + $getTimeDiff->d) * 24 + $getTimeDiff->h) * 60 + $getTimeDiff->i) * 60 + $getTimeDiff->s) * 1000);
                                }
							}
							
							if(($get_time_difference > 0) && ($get_time_difference <= 86400000)) {
                                continue;

                            } else {
                                $apiResponse['response_code'] = 200;
								$apiResponse['response_data'] = ['coupon_id' => $t_n_coupon_id ];
								$apiResponse['response_msg'] = "Next available coupon";
								break;
                            }

						}
						else {
							$apiResponse['response_code'] = 200;
							$apiResponse['response_data'] = ['coupon_id' => $t_n_coupon_id ];
							$apiResponse['response_msg'] = "Next available coupon";
							break;
						}

					} 
					else {
						// if coupon not available 
						continue;
					}
				}

			} else {

				$apiResponse['response_code'] = 200;
				$apiResponse['response_data'] = ['coupon_id' => $pref_coup_id ];
				$apiResponse['response_msg'] = "Next available coupon";
			}


		}
		else {
			// if coupon hasn't exclude
			$apiResponse['response_code'] = 200;
			$apiResponse['response_data'] = ['coupon_id' => $pref_coup_id ];
			$apiResponse['response_msg'] = "Next available coupon";
		}

	} 
	else {
		$apiResponse['response_code'] = 200;
		$apiResponse['response_data'] = [];
		$apiResponse['response_msg'] = "No Coupons are available";
	} 
  
}

header('Content-Type: application/json');
echo json_encode($apiResponse);
