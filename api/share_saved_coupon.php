<?php
include("conn.php");
include("func/PushNotification.php");

$apiResponse  = array('response_code' => '','response_data' => '','response_msg' => '');

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $coupon_id = trim($_POST["coupon_id"]);
    $device_id = trim($_POST["device_id"]);

    // check if a saved coupon available
    $check = "SELECT * FROM `user_coupons` WHERE `device_id`='" . $device_id . "' AND `scan_coupon_id`=" . $coupon_id;
    $execute = $dbh->query($check);

    $rows = $execute->rowCount();

    if($rows > 0) {
        // update share status
        $update = "UPDATE `user_coupons` SET `is_shared`= 1 WHERE `device_id`='" . $device_id . "' AND `scan_coupon_id`=" . $coupon_id;
        $executeUPD = $dbh->query($update);

        $updRows = $executeUPD->rowCount();

        if($updRows > 0) {
            $apiResponse['response_code'] = 200;
            $apiResponse['response_msg'] = "shared_successfully";
            $apiResponse['response_data'] = ['is_shared' => 1];
        } else {
            $apiResponse['response_code'] = 200;
            $apiResponse['response_msg'] = "shared_failed";
            $apiResponse['response_data'] = ['is_shared' => 0];
        }
    }
    else {
        $apiResponse['response_code'] = 200;
        $apiResponse['response_msg'] = "no_saved_coupon";
        $apiResponse['response_data'] = ['is_shared' => 0];
    }

}

header('Content-Type: application/json');
echo json_encode($apiResponse);