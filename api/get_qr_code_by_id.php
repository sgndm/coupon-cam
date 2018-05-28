<?php
include('conn.php');
$apiResponse  = array('response_code' => '','response_data' => '','response_msg' => '');

if($_SERVER['REQUEST_METHOD'] == 'POST') {

	//$device_id = trim($_POST['device_id']);
	$place_id = trim($_POST['place_id']);

	// | Check if user is a subscribed user or not | //
	$sql = "SELECT `qr_code` FROM `places` WHERE `place_id`=" . $place_id;
	$res = $dbh->query($sql);
	$rows = $res->rowCount();
	$result = $res->fetchAll(PDO::FETCH_ASSOC);

	$qr_code = $result[0]['qr_code'];

	if($rows > 0) {
		$apiResponse['response_code'] = 200;
		$apiResponse['response_data'] = array('qr_code' => $qr_code, 'place_id' => $place_id);
		$apiResponse['response_msg'] = "Qr Code";
	} else {
		$apiResponse['response_code'] = 200;
		$apiResponse['response_data'] = array('qr_code' => '', 'place_id' => $place_id);
		$apiResponse['response_msg'] = "Qr Code not found";
	}

}

header('Content-Type: application/json');
echo json_encode($apiResponse);
