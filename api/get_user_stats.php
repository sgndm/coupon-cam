<?php
include("conn.php");
$apiResponse  = array('response_code' => '','response_data' => '','response_msg' => '');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	// | Get Data From Request |
	$device_id = trim($_POST["device_id"]);
	
	// | Get all saved coupons with coupon details | //
	$sql = "SELECT `user_coupons`.*,`coupons`.* FROM `user_coupons` LEFT JOIN `coupons`ON `coupons`.`coupon_id`=`user_coupons`.`scan_coupon_id` WHERE `user_coupons`.`device_id`='".$device_id."'";
	
	$res = $dbh->query($sql);
	$rows = $res->rowCount();
	$saved_coupons = $res->fetchall(PDO::FETCH_OBJ);	
	
	// | calculate stats | //
	// | counts | //
	
	// | since download | //
	$total_saved_coupons = 0;
	$total_redeemed_coupons = 0;
	$total_expired_coupons = 0;
	$total_saved_value = 0;
	$total_missed_values = 0;
	
	// |this month | //
	$saved_coupon_count_this_month = 0;
	$redeemd_coupons_count_this_month = 0;
	$expired_coupons_count_this_month = 0;
	$saved_value_this_month = 0;
	$missed_value_this_month = 0;
	
	
	foreach ($saved_coupons as $coupon) {
		// | get all stats | //
		// | get redeem coupons | //
		if ($coupon->scan_coupon_status == 2) {
			// | get saved coupon count | //
			$total_saved_coupons += intval($coupon->total_used_times);
			
			// | get redeemed coupon count and amount | //
			$total_redeemed_coupons += intval($coupon->total_used_times);
			$total_saved_value += ( intval($coupon->estimated_value) * intval($coupon->total_used_times) );
			
		} 
		// | get expired coupons | //
		else if($coupon->scan_coupon_status == 3) {
			// | get saved coupon count | //
			$total_saved_coupons += 1;
			
			// | get expired coupon count and amount | //
			$total_expired_coupons += 1;
			$total_missed_values += $coupon->estimated_value;
			
		} else {
			// | get saved coupon count | //
			$total_saved_coupons += 1;
		}
		
		// | get this month stats | //
		$saved_date = date($coupon->scan_date);
		$stm = explode("-", $saved_date);
		$saved_year = $stm[0];
		$saved_month = $stm[1];
		
		$curr_year = date("Y");
		$curr_month = date("m");
		
		
		if( ($saved_year == $curr_year) && ($saved_month == $curr_month) ){
			
			// | get redeem coupons | //
			if ($coupon->scan_coupon_status == 2) {
				// | get saved coupon count | //
				$saved_coupon_count_this_month += intval($coupon->total_used_times);
				// | get redeemed coupon count and amount| //
				$redeemd_coupons_count_this_month += intval($coupon->total_used_times);
				$saved_value_this_month += ( intval($coupon->estimated_value) * intval($coupon->total_used_times) );
				
			} 
			// | get expired coupons | //
			else if($coupon->scan_coupon_status == 3) {
				// | get saved coupon count | //
				$saved_coupon_count_this_month += 1;
				
				// | get expired coupon count and amount | //
				$expired_coupons_count_this_month += 1;
				$missed_value_this_month += $coupon->estimated_value;
				
			} else {
				// | get saved coupon count | //
				$saved_coupon_count_this_month += 1;
			}
			
		} else {
			continue;
		}
		
	}

	
	$this_month = [
		"total_coupons" => $saved_coupon_count_this_month,
		"used_coupons" => $redeemd_coupons_count_this_month,
		"expired_coupons" => $expired_coupons_count_this_month,
		"total_savings" => $saved_value_this_month,
		"missed_amount" => $missed_value_this_month
	];
	
	$since_download = [
		"total_coupons" => $total_saved_coupons,
		"used_coupons" => $total_redeemed_coupons,
		"expired_coupons" => $total_expired_coupons,
		"total_savings" => $total_saved_value,
		"missed_amount" => $total_missed_values
	];
	
	
	
	$apiResponse['response_code'] = 200;
	$apiResponse['response_data'] = [
		"this_month" => $this_month,
		"since_download" => $since_download
	];
	$apiResponse['response_msg'] = 'User stats are here';
}

header('Content-Type: application/json');
echo json_encode($apiResponse);