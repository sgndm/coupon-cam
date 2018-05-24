<?php
include("conn.php");
$apiResponse  = array('response_code' => '','response_data' => '','response_msg' => '');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	$device_id = trim($_POST['device_id']);
	$coupon_id = trim($_POST['coupon_id']);
	
	// | Check user coupons | //
	$sql = "SELECT * FROM `user_coupons` WHERE `device_id`='" . $device_id . "' AND `scan_coupon_id`='" . $coupon_id . "'";
	$res = $dbh->query($sql);
	$rows = $res->rowCount();
	$saved_coupons = $res->fetchall(PDO::FETCH_OBJ);
	
	if($rows > 0) {
		// | If coupon available | //
		// | Check for loyalty coupon | //
		$sql2 = "SELECT * FROM `coupons` WHERE `coupon_id`='" . $coupon_id . "'";
		$res2 = $dbh->query($sql2);
		$rows2 = $res2->rowCount();
		$coupon_details = $res2->fetchall(PDO::FETCH_OBJ);
		
		$is_loyalty = $coupon_details[0]->is_loyalty;
		$count_occupied = $coupon_details[0]->count_occupied;
		$new_count_occupied = 0;
		
		$used_count = $saved_coupons[0]->used_times;
		$new_used_count = 0;
		
		$total_used_counts = $saved_coupons[0]->total_used_times;
		$new_total_used_times = 0;
			
		if($is_loyalty == 1) {
			// | if is loyalty coupon | //
			$loyalty_count = $coupon_details[0]->loyalty_count;
			
			// | check used coupon count | //
			if($used_count == 0) {
				$is_bonus = $saved_coupons[0]->is_bonus;
				
				if($is_bonus == 1) {
					$new_total_used_times = $total_used_counts + 1;
					// | update user coupon table | //
					$sql3 = "UPDATE `user_coupons` SET `scan_coupon_status`=2,`redeem_date`='" . date("Y-m-d H:i:s") . "',`is_bonus`=0,`total_used_times`=" . $new_total_used_times . " WHERE `device_id`='" . $device_id . "' AND `scan_coupon_id`='" . $coupon_id . "'";
					
					$res3 = $dbh->query($sql3);
					$rows3 = $res3->rowCount();
					
					if($rows3 > 0) {
						// | update count coupon occupied | //
						$new_count_occupied = $count_occupied + 1;
						$sql4 = "UPDATE `coupons` SET `count_occupied`=" . $new_count_occupied . " WHERE `coupon_id`='" . $coupon_id . "'";
					
						$res4 = $dbh->query($sql4);
						$rows4 = $res4->rowCount();
						
						if($rows4 > 0) {
							$apiResponse['response_code'] = 200;
							$apiResponse['response_data'] = array('coupon_id' => $coupon_id, 'device_id' => $device_id,'is_loyalty' => 1, 'loyalty_count' => $loyalty_count, 'used_count' => $new_used_count);
							$apiResponse['response_msg'] = "Coupon redeemed successfully!";
						} else {
							$apiResponse['response_code'] = 200;
							$apiResponse['response_data'] = array('coupon_id' => $coupon_id, 'device_id' => $device_id,'is_loyalty' => 1, 'loyalty_count' => $loyalty_count, 'used_count' => $used_count);
							$apiResponse['response_msg'] = "Redeem coupon failed!";
						}
						
						
					} 
					else {
						
						$apiResponse['response_code'] = 200;
						$apiResponse['response_data'] = array('coupon_id' => $coupon_id, 'device_id' => $device_id,'is_loyalty' => 1, 'loyalty_count' => $loyalty_count, 'used_count' => $used_count);
						$apiResponse['response_msg'] = "Redeem coupon failed!";
						
					}
				} else {
					$new_used_count = $used_count + 1;
					$new_total_used_times = $total_used_counts + 1;
					// | update user coupon table | //
					$sql3 = "UPDATE `user_coupons` SET `scan_coupon_status`=2,`redeem_date`='" . date("Y-m-d H:i:s") . "',`used_times`='" . $new_used_count . "',`total_used_times`=" . $new_total_used_times . " WHERE `device_id`='" . $device_id . "' AND `scan_coupon_id`='" . $coupon_id . "'";
					
					$res3 = $dbh->query($sql3);
					$rows3 = $res3->rowCount();
					
					if($rows3 > 0) {
						
						// | update count coupon occupied | //
						$new_count_occupied = $count_occupied + 1;
						$sql4 = "UPDATE `coupons` SET `count_occupied`=" . $new_count_occupied . " WHERE `coupon_id`='" . $coupon_id . "'";
					
						$res4 = $dbh->query($sql4);
						$rows4 = $res4->rowCount();
						
						if($rows4 > 0) {
							$apiResponse['response_code'] = 200;
							$apiResponse['response_data'] = array('coupon_id' => $coupon_id, 'device_id' => $device_id,'is_loyalty' => 1, 'loyalty_count' => $loyalty_count, 'used_count' => $new_used_count);
							$apiResponse['response_msg'] = "Coupon redeemed successfully!";
						} else {
							$apiResponse['response_code'] = 200;
							$apiResponse['response_data'] = array('coupon_id' => $coupon_id, 'device_id' => $device_id,'is_loyalty' => 1, 'loyalty_count' => $loyalty_count, 'used_count' => $used_count);
							$apiResponse['response_msg'] = "Redeem coupon failed!";
						}
						
						
					} 
					else {
						
						$apiResponse['response_code'] = 200;
						$apiResponse['response_data'] = array('coupon_id' => $coupon_id, 'device_id' => $device_id,'is_loyalty' => 1, 'loyalty_count' => $loyalty_count, 'used_count' => $used_count);
						$apiResponse['response_msg'] = "Redeem coupon failed!";
						
					}
				}
			}
			else if($used_count < ($loyalty_count - 1)) {
				$new_used_count = $used_count + 1;
				$new_total_used_times = $total_used_counts + 1;
				// | update user coupon table | //
				$sql3 = "UPDATE `user_coupons` SET `scan_coupon_status`=2,`redeem_date`='" . date("Y-m-d H:i:s") . "',`used_times`='" . $new_used_count . "',`total_used_times`=" . $new_total_used_times . " WHERE `device_id`='" . $device_id . "' AND `scan_coupon_id`='" . $coupon_id . "'";
				
				$res3 = $dbh->query($sql3);
				$rows3 = $res3->rowCount();
				
				if($rows3 > 0) {
					
					// | update count coupon occupied | //
					$new_count_occupied = $count_occupied + 1;
					$sql4 = "UPDATE `coupons` SET `count_occupied`=" . $new_count_occupied . " WHERE `coupon_id`='" . $coupon_id . "'";
				
					$res4 = $dbh->query($sql4);
					$rows4 = $res4->rowCount();
					
					if($rows4 > 0) {
						$apiResponse['response_code'] = 200;
						$apiResponse['response_data'] = array('coupon_id' => $coupon_id, 'device_id' => $device_id,'is_loyalty' => 1, 'loyalty_count' => $loyalty_count, 'used_count' => $new_used_count);
						$apiResponse['response_msg'] = "Coupon redeemed successfully!";
					} else {
						$apiResponse['response_code'] = 200;
						$apiResponse['response_data'] = array('coupon_id' => $coupon_id, 'device_id' => $device_id,'is_loyalty' => 1, 'loyalty_count' => $loyalty_count, 'used_count' => $used_count);
						$apiResponse['response_msg'] = "Redeem coupon failed!";
					}
					
					
				} 
				else {
					
					$apiResponse['response_code'] = 200;
					$apiResponse['response_data'] = array('coupon_id' => $coupon_id, 'device_id' => $device_id,'is_loyalty' => 1, 'loyalty_count' => $loyalty_count, 'used_count' => $used_count);
					$apiResponse['response_msg'] = "Redeem coupon failed!";
					
				}
				
			} else if($used_count == ($loyalty_count - 1)) {
				// | if loyalty count == used count | //
				// | reset used count | //
				$new_used_count = 0;
				$new_total_used_times = $total_used_counts + 1;
				// | update user coupon table | //
				$sql5 = "UPDATE `user_coupons` SET `scan_coupon_status`=2,`redeem_date`='" . date("Y-m-d H:i:s") . "',`used_times`='" . $new_used_count . "',`is_bonus`=1,`total_used_times`=" . $new_total_used_times . " WHERE `device_id`='" . $device_id . "' AND `scan_coupon_id`='" . $coupon_id . "'";
				
				$res5 = $dbh->query($sql5);
				$rows5 = $res5->rowCount();
				
				if($rows5 > 0) {
					
					// | update count coupon occupied | //
					$new_count_occupied = $count_occupied + 1;
					$sql4 = "UPDATE `coupons` SET `count_occupied`=" . $new_count_occupied . " WHERE `coupon_id`='" . $coupon_id . "'";
				
					$res4 = $dbh->query($sql4);
					$rows4 = $res4->rowCount();
					
					if($rows4 > 0) {
						$apiResponse['response_code'] = 200;
						$apiResponse['response_data'] = array('coupon_id' => $coupon_id, 'device_id' => $device_id,'is_loyalty' => 1, 'loyalty_count' => $loyalty_count, 'used_count' => ($used_count + 1) );
						$apiResponse['response_msg'] = "Coupon redeemed successfully!";
					} else {
						$apiResponse['response_code'] = 200;
						$apiResponse['response_data'] = array('coupon_id' => $coupon_id, 'device_id' => $device_id,'is_loyalty' => 1, 'loyalty_count' => $loyalty_count, 'used_count' => $used_count);
						$apiResponse['response_msg'] = "Redeem coupon failed!";
					}
					
					
				} 
				else {
					
					$apiResponse['response_code'] = 200;
					$apiResponse['response_data'] = array('coupon_id' => $coupon_id, 'device_id' => $device_id,'is_loyalty' => 1, 'loyalty_count' => $loyalty_count, 'used_count' => $used_count);
					$apiResponse['response_msg'] = "Redeem coupon failed!";
					
				}
			}
			
		} else {
			$coupon_status = $saved_coupons[0]->scan_coupon_status;
			
			if($coupon_status == 4) {
				//$new_used_count = $used_count + 1;
				$new_total_used_times = $total_used_counts + 1;
				// | update user coupon table | //
				$sql3 = "UPDATE `user_coupons` SET `scan_coupon_status`=2,`redeem_date`='" . date("Y-m-d H:i:s") . "',`total_used_times`=" . $new_total_used_times . " WHERE `device_id`='" . $device_id . "' AND `scan_coupon_id`='" . $coupon_id . "'";
				
				$res3 = $dbh->query($sql3);
				$rows3 = $res3->rowCount();
				
				if($rows3 > 0) {
					$apiResponse['response_code'] = 200;
					$apiResponse['response_data'] = array('coupon_id' => $coupon_id, 'device_id' => $device_id,'is_loyalty' => 0, 'loyalty_count' => 0, 'used_count' => 0);
					$apiResponse['response_msg'] = "Coupon redeemed successfully!";
				} else {
					$apiResponse['response_code'] = 200;
					$apiResponse['response_data'] = array('coupon_id' => $coupon_id, 'device_id' => $device_id,'is_loyalty' => 0, 'loyalty_count' => 0, 'used_count' => 0);
					$apiResponse['response_msg'] = "Redeem coupon failed!";
				}
			}
			if($coupon_status == 1) {
				//$new_used_count = $used_count + 1;
				$new_total_used_times = $total_used_counts + 1;
				// | update user coupon table | //
				$sql3 = "UPDATE `user_coupons` SET `scan_coupon_status`=2,`redeem_date`='" . date("Y-m-d H:i:s") . "',`total_used_times`=" . $new_total_used_times . " WHERE `device_id`='" . $device_id . "' AND `scan_coupon_id`='" . $coupon_id . "'";
				
				$res3 = $dbh->query($sql3);
				$rows3 = $res3->rowCount();
				
				if($rows3 > 0) {
					$apiResponse['response_code'] = 200;
					$apiResponse['response_data'] = array('coupon_id' => $coupon_id, 'device_id' => $device_id,'is_loyalty' => 0, 'loyalty_count' => 0, 'used_count' => 0);
					$apiResponse['response_msg'] = "Coupon redeemed successfully!";
				} else {
					$apiResponse['response_code'] = 200;
					$apiResponse['response_data'] = array('coupon_id' => $coupon_id, 'device_id' => $device_id,'is_loyalty' => 0, 'loyalty_count' => 0, 'used_count' => 0);
					$apiResponse['response_msg'] = "Redeem coupon failed!";
				}
			}
		}
			
		
	} else {
		// | If coupon not available | //
		$apiResponse['response_code'] = 200;
		$apiResponse['response_data'] = array('coupon_id' => $coupon_id, 'device_id' => $device_id,'is_loyalty' => 0, 'loyalty_count' => 0, 'used_count' => 0);
		$apiResponse['response_msg'] = "Invalid coupon id or device id";
		
	}
	
}

header('Content-Type: application/json');
echo json_encode($apiResponse);