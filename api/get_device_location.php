<?php
include('conn.php');
$apiResponse  = array('response_code' => '','response_data' => '','response_msg' => '');


if($_SERVER['REQUEST_METHOD'] == 'POST') {

	$device_id = trim($_POST['device_id']);
	$latitude = trim($_POST['latitude']);
	$longitude = trim($_POST['longitude']);


	$sql1 = "SELECT * FROM `device_locations` WHERE `device_id` = '" . $device_id . "'";
	$res1 = $dbh->query($sql1);
	$rows1 = $res1->rowCount();

	if($rows1 > 0) {

		$sql2 = "UPDATE `device_locations` SET `latitude`='" . $latitude . "',`longitude`='" . $longitude . "',`last_updated`='" . date('Y-m-d H:i:s') . "' WHERE `device_id`='" . $device_id . "' ";
		$res2 = $dbh->query($sql2);
		$rows2 = $res2->rowCount();

		// update user device details table
		$upUD = "UPDATE `users_device_details` SET `lat`='" . $latitude . "',`lng`='" . $longitude . "'  WHERE `device_id`='" . $device_id . "' ";
		$execUPD = $dbh->query($upUD);

		if($rows2 > 0) {
			$apiResponse['response_code']		= '200';
			$apiResponse['response_data'] 	= array('device_id' => $device_id, 'is_updated' => 1);
			$apiResponse['response_msg'] 		= 'Device location updated successfully';
		} else {
			$apiResponse['response_code']		= '200';
			$apiResponse['response_data'] 	= array('device_id' => $device_id, 'is_updated' => 0);
			$apiResponse['response_msg'] 		= 'Failed updating device location';
		}

	}
	else {

		$sql3 = "INSERT INTO `device_locations`(`device_id`, `latitude`, `longitude`, `last_updated`) VALUES ('" . $device_id . "','" . $latitude . "','" . $longitude . "','" . date('Y-m-d H:i:s') . "')";
		$res3 = $dbh->query($sql3);
		$rows3 = $res3->rowCount();

		if($rows3 > 0){
			$apiResponse['response_code']		= '200';
			$apiResponse['response_data'] 	= array('device_id' => $device_id, 'is_updated' => 1);
			$apiResponse['response_msg'] 		= 'Device location updated  successful';
		} else {
			$apiResponse['response_code']		= '200';
			$apiResponse['response_data'] 	= array('device_id' => $device_id, 'is_updated' => 0);
			$apiResponse['response_msg'] 		= 'Failed updating device location';
		}

	}



}

header('Content-Type: application/json');
echo json_encode($apiResponse);
