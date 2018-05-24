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
		$sql2 = "DELETE FROM `user_coupons` WHERE `device_id`='". $device_id ."'";
		$res2 = $dbh->query($sql2);
		$rows2 = $res2->rowCount();
		
		$apiResponse['response_code'] = 200;
		$apiResponse['response_data'] = array('device_id' => $device_id);
		$apiResponse['response_code'] = "Saved coupons deleted successfully";
	} else {
		$apiResponse['response_code'] = 200;
		$apiResponse['response_data'] = array('device_id' => $device_id);
		$apiResponse['response_code'] = "No coupons to delete";
	}
}

header('Content-Type: application/json');
echo json_encode($apiResponse);