<?php
include("conn.php");

$apiResponse  = array('response_code' => '','response_data' => array(),'response_msg' => '');

if($_SERVER['REQUEST_METHOD'] == 'POST') {

  // get device id
  $device_id = trim($_POST['device_id']);

  $sql = " SELECT `user_coupons`.*,`user_coupons`.`place_id` AS store_id,`promos`.*,`coupons`.* FROM `user_coupons` LEFT JOIN `promos` ON `promos`.`promo_id`=`user_coupons`.`scan_promo_id` LEFT JOIN `coupons`ON `coupons`.`coupon_id`=`user_coupons`.`scan_coupon_id` WHERE `user_coupons`.`device_id`='".$device_id."' AND `user_coupons`.`scan_coupon_status`=3";

	$res = $dbh->query($sql);
	$rows = $res->rowCount();
	$saved_coupons = $res->fetchall(PDO::FETCH_OBJ);

  foreach ($saved_coupons as $saved) {
    $store_id = $saved->store_id;

    // get store details
    $getSt = "SELECT * FROM `places` WHERE `place_id`=" . $store_id;
    $excute = $dbh->query($getSt);
    $store_details = $excute->fetchall(PDO::FETCH_OBJ);
    
    /// store name 
    $store_name = $store_details[0]->contact_name;
    $saved->store_name = $store_name;

    // get country
    $country = $store_details[0]->country_short;

    if($country == 'GB') {
      $saved->currency_lable = '£';
    }
    else if($country == 'NZ') {
      $saved->currency_lable = '$';
    }
    else if($country == 'CA') {
      $saved->currency_lable = 'C$';
    }
    else if($country == 'AU') {
      $saved->currency_lable = 'A$';
    }
    else {
      $saved->currency_lable = '$';
    }

    // get extend values for country
    $C_country = 'US';
    // check country
    if( ($country == 'GB') || ($country == 'NZ') || ($country == 'CA') || ($country == 'AU') ) {
      $C_country = $country;
    }

    $get_val = "SELECT * FROM `extending_values` WHERE `country`='" . $C_country . "'";
    $exc = $dbh->query($get_val);
    $get_extend_amount = $exc->fetchall(PDO::FETCH_OBJ);

    $extend_amaount = $get_extend_amount[0]->value;

    // add to return data set
    $saved->extend_value = $extend_amaount;

  }

  $apiResponse['response_code'] = 200;
  $apiResponse['response_data'] = $saved_coupons;
  $apiResponse['response_msg'] = "Expired Coupons";

}


header('Content-Type: application/json');
echo json_encode($apiResponse);
