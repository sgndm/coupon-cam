<?php
include('conn.php');
$apiResponse  = array('response_code' => '','response_data' => '','response_msg' => '');

if($_SERVER['REQUEST_METHOD'] == 'POST') {

	//$device_id = trim($_POST['device_id']);
	$promo_id = trim($_POST['promo_id']);

	// | Check if user is a subscribed user or not | //
	$sql = "SELECT * FROM `promos` WHERE `promo_id`='" . $promo_id . "'";
	$res = $dbh->query($sql);
	$rows = $res->rowCount();
    $result = $res->fetchAll(PDO::FETCH_ASSOC);
    
    $sql2 = "SELECT * FROM `coupons` WHERE `promo_id` =" .$promo_id;
    $coups = $dbh->query($sql2);
    $num_rows = $coups->rowCount();
    $all_coupons = $coups->fetchAll(PDO::FETCH_OBJ);


	if($rows > 0 && $num_rows > 0) {
		$apiResponse['response_code'] = 200;
        // $apiResponse['response_data'] = $result;
        $apiResponse['response_data'] = $all_coupons;
		$apiResponse['response_msg'] = "promo_details";
	} else {
		$apiResponse['response_code'] = 200;
        $apiResponse['response_data'] = array();
        // $apiResponse['response_all_coupons'] = array();
		$apiResponse['response_msg'] = "promo_not_found";
	}

}

header('Content-Type: application/json');
echo json_encode($apiResponse);
