<?php
include('conn.php');
$apiResponse  = array('response_code' => '','response_data' => '','response_msg' => '');

if($_SERVER['REQUEST_METHOD'] == 'POST') {

	$device_id = trim($_POST['device_id']);
  $coupon_id = trim($_POST['coupon_id']);

  // get promo details
  $get_promo = "SELECT `promo_id` FROM `coupons` WHERE `coupon_id`=" . $coupon_id;
  $exec = $dbh->query($get_promo);
  $promo_det = $exec->fetchall(PDO::FETCH_OBJ);

  // promo id
  $promo_id = $promo_det[0]->promo_id;

  // today
  $today = date('Y-m-d H:i:s');

  // expire date
  $expire_date = date('Y-m-d H:i:s', strtotime($today . ' + 14 days'));
  // insert record to extend coupon details table
  $inst = "INSERT INTO `user_coupon_extended_details`(`device_id`,`coupon_id`,`promo_id`,`extended_date`,`expire_date`) VALUES('" . $device_id . "'," . $coupon_id . "," . $promo_id . ",'" . $today . "','" . $expire_date . "')";
  $execute = $dbh->query($inst);
  $instRows = $execute->rowCount();

  if($instRows > 0) {

    // update user coupons table
    $upd = "UPDATE `user_coupons` SET `scan_coupon_status`=4, `has_extended`=1 WHERE `device_id`='" . $device_id . "' AND `scan_coupon_id`=" . $coupon_id;
    $execUPD = $dbh->query($upd);
    $updRows = $execUPD->rowCount();

    if($updRows > 0){
      $apiResponse['response_code'] = 200;
      $apiResponse['response_data'] = ['has_extended' => 1];
      $apiResponse['response_msg'] = "Coupon Extended successfully!";
    }
    else {
      $apiResponse['response_code'] = 200;
      $apiResponse['response_data'] = ['has_extended' => 0];
      $apiResponse['response_msg'] = "Coupon Extention failed!";
    }



  }
  else {
    $apiResponse['response_code'] = 200;
    $apiResponse['response_data'] = ['has_extended' => 0];
    $apiResponse['response_msg'] = "Coupon Extention failed!";
  }

}


header('Content-Type: application/json');
echo json_encode($apiResponse);
