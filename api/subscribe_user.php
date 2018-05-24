<?php
include('conn.php');
$apiResponse  = array('response_code' => '','response_data' => '','response_msg' => '');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	$device_id = trim($_POST['device_id']);
	$status = trim($_POST['status']);
	
	// | Check if user is a subscribed user or not | //
	/*
	$sql = "SELECT `is_subscribed` FROM `users_device_details` WHERE `device_id`='" . $device_id . "'";
	$res = $dbh->query($sql);
	$rows = $res->rowCount();
	$result = $res->fetchAll(PDO::FETCH_ASSOC);
	
	$is_subscribed = $result[0]['is_subscribed'];
	*/
	
	if($status == 1) {
		
		// | subscribe | //
		$sql3 = "UPDATE `users_device_details` SET `is_subscribed`=1 WHERE `device_id`='" . $device_id . "'";
		$res3 = $dbh->query($sql3);
		$rows3 = $res3->rowCount();
		
		$apiResponse['response_code'] = 200;
		$apiResponse['response_data'] = array('device_id' => $device_id, 'is_subscribed' => 1 );
		$apiResponse['response_msg'] = 'User subscribed successfully!';
		
		/*if($rows3 > 0) {
			
		} else {
			$apiResponse['response_code'] = 200;
			$apiResponse['response_data'] = array('device_id' => $device_id, 'is_subscribed' => 0 );
			$apiResponse['response_msg'] = 'User subscribe failed!';
		}*/
		
		
	} else {
		// | unsubscribe | //
		$sql2 = "UPDATE `users_device_details` SET `is_subscribed`=0 WHERE `device_id`='" . $device_id . "'";
		$res2 = $dbh->query($sql2);
		$rows2 = $res2->rowCount();
		
		$apiResponse['response_code'] = 200;
		$apiResponse['response_data'] = array('device_id' => $device_id, 'is_subscribed' => 0 );
		$apiResponse['response_msg'] = 'User unsubscribed successfully!';
		
		/*if($rows2 > 0) {
			
		} else {
			$apiResponse['response_code'] = 200;
			$apiResponse['response_data'] = array('device_id' => $device_id, 'is_subscribed' => 1 );
			$apiResponse['response_msg'] = 'User unsubscribe failed!';
		}*/
	}
	
	
	
}


header('Content-Type: application/json');
echo json_encode($apiResponse);