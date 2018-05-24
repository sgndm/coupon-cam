<?php
include('conn.php');
$apiResponse  = array('response_code' => '','response_data' => [],'response_msg' => '');

if($_SERVER['REQUEST_METHOD'] == 'POST') {

  $device_id = $_POST['device_id'];
  $red_promo_id = $_POST['red_promo_id'];
  // $has_saved = $_POST['has_saved'];
  // $saved_coupon_id = $_POST['saved_coupon_id'];

  $delOther = "DELETE FROM `user_reserved_coupons` WHERE `status`=0 AND `promo_id`=" . $red_promo_id . " AND `device_id`='" . $device_id . "'";

  $execDel = $dbh->query($delOther);
  $delRows = $execDel->rowCount();

  if($delRows > 0) {
    $apiResponse['response_code'] = 200;
    $apiResponse['response_data'] = ['is_deleted' => 1];
    $apiResponse['response_msg'] = 'Records deleted Successfully!';
  }
  else {
    $apiResponse['response_code'] = 200;
    $apiResponse['response_data'] = ['is_deleted' => 0];
    $apiResponse['response_msg'] = 'Unable to delete records';
  }

}


header('Content-Type: application/json');
echo json_encode($apiResponse);
