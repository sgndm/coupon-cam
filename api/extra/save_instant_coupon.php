<?php
include("conn.php");
$apiResponse  = array('response_code' => '','response_data' => '','response_msg' => '');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	// | Get Data From Request |
	$place_id = trim($_POST["place_id"]);
	$device_id = trim($_POST["device_id"]);
	$coupon_id = trim($_POST["coupon_id"]);
	
	// | Validate Promo Id

	if(empty($device_id)) {
		
		$apiResponse['response_code']		= '202';
		$apiResponse['response_data'] 	= array(
							'device_id' => $device_id
						);
		$apiResponse['response_msg'] 		= 'Device id is blank';
		
	// | Validate coupon id
	}
	else if(empty($place_id)) {
		
		$apiResponse['response_code']		= '202';
		$apiResponse['response_data'] 	= array(
							'place_id' => $place_id
						);
		$apiResponse['response_msg'] 		= 'place id is blank';
		
	// | Validate coupon id
	}else if(empty($coupon_id)) {
		
		$apiResponse['response_code']		= '203';
		$apiResponse['response_data'] 	= array(
							'coupon_id' => $coupon_id
						);
		$apiResponse['response_msg'] 		= 'Coupon id is blank or not numeric value';
		
	// | if all are verified	
	}else {
        
        // | check if store has verified | //
        $sqln = "SELECT * FROM `places` WHERE `place_id` = '" . $place_id . "'";
		$resn = $dbh->query($sqln);
		$rowsn = $resn->rowCount();
		$resultn = $resn->fetchAll(PDO::FETCH_ASSOC);
		
		$is_verified = $resultn[0]['is_verified'];
		
		// | Get promo id
		$sql = "SELECT * FROM `coupons` WHERE `coupon_id` = '" . $coupon_id . "'";
		$res = $dbh->query($sql);
		$rows = $res->rowCount();
		$result = $res->fetchAll(PDO::FETCH_ASSOC);
		
		$promo_id = $result[0]['promo_id'];
		
		// | Check promo | if available
		$sql1 = "SELECT * FROM `promos` WHERE `promo_id` = '" . $promo_id . "'";
		$res1 = $dbh->query($sql1);
		$rows1 = $res1->rowCount();
		
		if($rows1 > 0) {
			//| Check coupon | if available
			$sql2 = "SELECT * FROM `coupons` WHERE `coupon_id` = '" . $coupon_id . "'";
			$res2 = $dbh->query($sql2);
			$rows2 = $res2->rowCount();
			$result2 = $res2->fetchAll(PDO::FETCH_ASSOC);
			
			$count_occupied = $result2[0]['count_occupied'];
			
			if($rows2 > 0) {
				
				// | check if coupon has reserved before by this device
				$sql3 = "SELECT * FROM `user_coupons` WHERE `scan_promo_id`=".$promo_id." AND `scan_coupon_id`=".$coupon_id." AND `device_id`='".$device_id."' ";
				$res3 = $dbh->query($sql3);
				$rows3 = $res3->rowCount();
				
				if($rows3 > 0) {
					
					$apiResponse['response_code']		= '206';
					$apiResponse['response_data'] 	= array(
							'promo_id' => $promo_id,
							'coupon_id' => $coupon_id,
                            'place_id' => $place_id,
                            'is_verified' => $is_verified
						);
					$apiResponse['response_msg'] 		= 'You have already reserved this item';
					
				} else {
					
					$sql4 = "INSERT INTO `user_coupons`(`scan_promo_id`, `scan_coupon_id`,`device_id`, `scan_coupon_status`,`place_id`) VALUES ('" . $promo_id . "','" . $coupon_id . "','" . $device_id . "', '1'," . $place_id . ")";
					$res4 = $dbh->query($sql4);
					$rows4 = $res4->rowCount();
					
					$new_ocupied_count = $count_occupied + 1;
					
					$sql5 = "UPDATE `coupons` SET `count_occupied`='" . $new_ocupied_count . "' WHERE `coupon_id` = '" . $coupon_id . "'";
					$res5 = $dbh->query($sql5);
					$rows5 = $res5->rowCount();
					
					if(($rows4 > 0) && ($rows5 > 0)) {
						
						$apiResponse['response_code']		= '200';
						$apiResponse['response_data'] 	= array(
							'promo_id' => $promo_id,
							'coupon_id' => $coupon_id,
                            'place_id' => $place_id,
                            'is_verified' => $is_verified
						);
                        
                        if($is_verified == 1) {
                            $apiResponse['response_msg'] 		= 'Congratulations! You have been reserved the coupon successfully';
                        } else {
                            $apiResponse['response_msg'] 		= 'saved_from_not_verified_store';
                        }
						
						
					} else {
						
						$apiResponse['response_code']		= '200';
						$apiResponse['response_data'] 	= array(
							'promo_id' => $promo_id,
							'coupon_id' => $coupon_id,
                            'place_id' => $place_id,
                            'is_verified' => $is_verified
						);
						$apiResponse['response_msg'] 		= 'Oops! Something went wrong. You were unable to reserve the coupon!!';
						
					}		
					
					
				}
				
			} else {
				$apiResponse['response_code']		= '205';
				$apiResponse['response_data'] 	= array(
							'coupon_id' => $coupon_id,
                            'place_id' => $place_id,
                            'is_verified' => $is_verified
						);
				$apiResponse['response_msg'] 		= 'Invalid coupon id';
			}
			
		} else {
			
			$apiResponse['response_code']		= '204';
			$apiResponse['response_data'] 	= array(
							'promo_id' => $promo_id,
                            'place_id' => $place_id,
                            'is_verified' => $is_verified
						);
			$apiResponse['response_msg'] 		= 'Invalid promo id';
			
		}
		
		
		
	}
}

header('Content-Type: application/json');
echo json_encode($apiResponse);
