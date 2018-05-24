<?php
include('conn.php');
$apiResponse  = array('response_code' => '','response_data' => '','response_msg' => '');


if($_SERVER['REQUEST_METHOD'] == 'POST') {

	$device_id = trim($_POST['device_id']);
	$latitude = trim($_POST['latitude']);
	$longitude = trim($_POST['longitude']);

  $sql2 = "UPDATE `users_device_details` SET `lat`='" . $latitude . "',`lng`='" . $longitude . "',`last_open_date`='" . date('Y-m-d H:i:s') . "' WHERE `device_id`='" . $device_id . "' ";
  $res2 = $dbh->query($sql2);
  $rows2 = $res2->rowCount();

	$sql4 = "UPDATE `device_locations` SET `latitude`='" . $latitude . "',`longitude`='" . $longitude . "',`last_updated`='" . date('Y-m-d H:i:s') . "' WHERE `device_id`='" . $device_id . "' ";
	$res4 = $dbh->query($sql4);

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


header('Content-Type: application/json');
echo json_encode($apiResponse);
