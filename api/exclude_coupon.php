<?php
include('conn.php');
$apiResponse  = array('response_code' => '','response_data' => '','response_msg' => '');

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $device_id = trim($_POST['device_id']);
    $coupon_id = trim($_POST['coupon_id']);

    $sql = "INSERT INTO `exclued_coupons`(`device_id`,`coupon_id`,`date`,`created_at`,`updated_at`) VALUES ('" . $device_id . "', " . $coupon_id . ", '". date('Y-m-d') ."', '" . date('Y-m-d H:i:s') . "', '" . date('Y-m-d H:i:s') . "')";
    $execute = $dbh->query($sql);

    $rows = $execute->rowCount();

    if($rows > 0) {
        $apiResponse['response_code'] = 200;
        $apiResponse['response_msg'] = "excluded_successfully";
        $apiResponse['response_code'] = [];
    } else {
        $apiResponse['response_code'] = 200;
        $apiResponse['response_msg'] = "excluded_failed";
        $apiResponse['response_code'] = [];
    }

}

header('Content-Type: application/json');
echo json_encode($apiResponse);