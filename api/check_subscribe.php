<?php
include('conn.php');
$apiResponse  = array('response_code' => '','response_data' => '','response_msg' => '');

if($_SERVER['REQUEST_METHOD'] == 'POST') {

	$device_id = trim($_POST['device_id']);

	// | Check if user is a subscribed user or not | //
	$sql = "SELECT `is_subscribed` FROM `users_device_details` WHERE `device_id`='" . $device_id . "'";
	$res = $dbh->query($sql);
	$rows = $res->rowCount();
	$result = $res->fetchAll(PDO::FETCH_ASSOC);
	
	$is_subscribed = $result[0]['is_subscribed'];

	if($is_subscribed == 1) {
		$apiResponse['response_code'] = 200;
		$apiResponse['response_data'] = array('device_id' => $device_id, 'is_subscribed' => 1);
		$apiResponse['response_msg'] = "User has subscribed";
	} else {
		$apiResponse['response_code'] = 200;
		$apiResponse['response_data'] = array('device_id' => $device_id, 'is_subscribed' => 0);
		$apiResponse['response_msg'] = "User has not subscribed";
	}

}

header('Content-Type: application/json');
echo json_encode($apiResponse);
