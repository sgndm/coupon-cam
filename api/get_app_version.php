<?php
include('conn.php');
$apiResponse  = array('response_code' => '','response_data' => '','response_msg' => '');

// | Get android version |
$sql1 = "SELECT * FROM `settings` WHERE `id` = 2";
$res1 = $dbh->query($sql1);
$rows1 = $res1->rowCount();
$result1 = $res1->fetchAll(PDO::FETCH_ASSOC);

// | Get ios version |
$sql2 = "SELECT * FROM `settings` WHERE `id` = 3";
$res2 = $dbh->query($sql2);
$rows2 = $res2->rowCount();
$result2 = $res2->fetchAll(PDO::FETCH_ASSOC);

if( $rows1 > 0 || $rows2 > 0) {

	$apiResponse['response_code'] = '200';
	$apiResponse['response_data'] = array(
		'andorid_version' => $result1[0]['setting_value'],
		'ios_version' => $result2[0]['setting_value']
	);
	$apiResponse['response_msg'] = 'Get all version record';

} else {

	$apiResponse['response_code'] = 203;
	$apiResponse['response_data'] = array(
		'andorid_version' => 'Not Found',
		'ios_version' => 'Not Found'
	);
	$apiResponse['response_msg'] = 'No records found';

}

header('Content-Type: application/json');
echo json_encode($apiResponse);
