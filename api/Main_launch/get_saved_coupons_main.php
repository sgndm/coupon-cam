<?php
include("conn.php");

$apiResponse  = array('response_code' => '','response_data' => '','response_msg' => '');


if($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	$device_id = trim($_POST['device_id']);
	
	$sql = " SELECT `user_coupons`.*,`user_coupons`.`place_id` AS store_id,`promos`.*,`coupons`.* FROM `user_coupons` LEFT JOIN `promos` ON `promos`.`promo_id`=`user_coupons`.`scan_promo_id` LEFT JOIN `coupons`ON `coupons`.`coupon_id`=`user_coupons`.`scan_coupon_id` WHERE `user_coupons`.`device_id`='".$device_id."'";
	
	$res = $dbh->query($sql);
	$rows = $res->rowCount();
	$saved_coupons = $res->fetchall(PDO::FETCH_OBJ);
	
	if($rows > 0) {
		foreach($saved_coupons as $coupons) {
			$store_id = $coupons->store_id;
			$promo_id = $coupons->scan_promo_id;
			
			// | get location
			$sql2 = "SELECT `lat_code`,`lng_code` FROM `promo_locations` WHERE `store_id`='" . $store_id . "' AND `promo_id`='" . $promo_id . "'";
			$res2 = $dbh->query($sql2);
			$rows2 = $res2->rowCount();
			$lat_lng = $res2->fetchall(PDO::FETCH_OBJ);
			
			// | get Store Details
			$sql3 = "SELECT `contact_name`,`address` FROM `places` WHERE `place_id`='" . $store_id ."'";
			$res3 = $dbh->query($sql3);
			$rows3 = $res3->rowCount();
			$store_details = $res3->fetchall(PDO::FETCH_OBJ);
			
			$out = [
				"scan_id"=> $coupons->scan_id,
				"scan_promo_id"=>$coupons->scan_promo_id,
				"scan_coupon_id"=>$coupons->scan_coupon_id,
				"scan_ir_code"=> $coupons->scan_ir_code,
				"device_id"=> $coupons->device_id,
				"scan_coupon_status"=> $coupons->scan_coupon_status,
				"redeem_date"=> $coupons->redeem_date,
				"scan_date"=> $coupons->scan_date,
				"is_bonus"=> $coupons->is_bonus,
				"promo_id"=> $coupons->promo_id,
				"place_id"=> $coupons->store_id,
				"promo_name"=> $coupons->promo_name,
				"start_at"=> $coupons->start_at,
				"end_at"=> $coupons->end_at,
				"promo_length"=> $coupons->promo_length,
				"advance_warning"=> $coupons->advance_warning,
				"is_shown"=> $coupons->is_shown,
				"warning_start_time"=> $coupons->warning_start_time,
				"promo_repeat"=> $coupons->promo_repeat,
				"promo_repeat_values"=> $coupons->promo_repeat_values,
				"pre_launch_clue"=> $coupons->pre_launch_clue,
				"main_clue"=> $coupons->main_clue,
				"visible_now"=> $coupons->visible_now,
				"internal_promo"=> $coupons->internal_promo,
				"reference_image"=> $coupons->reference_image,
				"add_date"=> $coupons->add_date,
				"status"=> $coupons->status,
				"used"=> $coupons->used,
				"user_id"=> $coupons->user_id,
				"ir_code"=> $coupons->ir_code,
				"created_at"=> $coupons->created_at,
				"updated_at"=> $coupons->updated_at,
				"coupon_id"=> $coupons->coupon_id,
				"estimated_value"=> $coupons->estimated_value,
				"coupon_code"=> $coupons->coupon_code,
				"coupon_title"=> $coupons->coupon_title,
				"coupon_availabilty"=> $coupons->coupon_availabilty,
				"count_occupied"=> $coupons->count_occupied,
				"coupon_information"=> $coupons->coupon_information,
				"terms_conditions"=> $coupons->terms_conditions,
				"coupon_photo"=> $coupons->coupon_photo,
				"photo"=> $coupons->photo,
				"expire_date"=> $coupons->expire_date,
				"coupon_model"=> $coupons->coupon_model,
				"priority_order"=> $coupons->priority_order,
				"coupon_level"=> $coupons->coupon_level,
				"locations"=>$lat_lng,
				"is_loyalty" => $coupons->is_loyalty,
				"loyalty_count" => $coupons->loyalty_count,
				"used_count" => $coupons->used_times,
				"store_name" => $store_details[0]->contact_name,
				"store_address" => $store_details[0]->address
			];
			
			$apiResponse['response_data'][] = $out;
		}
	} else {
		//$apiResponse['response_code'] = 200;
		$apiResponse['response_data'] = array();
	}
	
	
	
	$apiResponse['response_code']='200';
	//$apiResponse['response_data']=$saved_coupons;
}

header('Content-Type: application/json');
echo json_encode($apiResponse);
