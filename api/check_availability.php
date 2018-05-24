<?php
include('conn.php');
$apiResponse  = array('response_code' => '','response_data' => '','response_msg' => '');

if($_SERVER['REQUEST_METHOD'] == 'POST') {

	$promo_id = trim($_POST['promo_id']);

  $get_coupons = "SELECT * FROM `coupons` WHERE `promo_id`=" . $promo_id . " AND (coupon_availabilty > count_occupied OR coupon_availabilty = 'Unlimited')"
  . "ORDER BY coupon_id ASC LIMIT 0,1";
  $exec = $dbh->query($get_coupons);
  $coupons = $exec->fetchAll(PDO::FETCH_OBJ);
  $rows = $exec->rowCount();

  if($rows > 0) {
    $apiResponse['response_code'] = 200;
    $apiResponse['response_data'] = ['coupon_id' => $coupons[0]->coupon_id ];
    $apiResponse['response_msg'] = "Next available coupon";
  }
  else {
    $apiResponse['response_code'] = 200;
    $apiResponse['response_data'] = [];
    $apiResponse['response_msg'] = "No Coupons are available";
  }


}

header('Content-Type: application/json');
echo json_encode($apiResponse);
