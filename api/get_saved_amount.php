<?php
include("conn.php");

$apiResponse  = array('response_code' => '','response_data' => array(),'response_msg' => '');

if($_SERVER['REQUEST_METHOD'] == 'POST') {

  $device_id = trim($_POST["device_id"]);

  // get app settings
	$get_appset = "SELECT * FROM `app_settings` WHERE `setting_name`='saving_limit'";
	$execLimit = $dbh->query($get_appset);
	$settings = $execLimit->fetchAll(PDO::FETCH_OBJ);

	$max_savings = $settings[0]->setting;


  $monthStDate = date('Y-m-01');
  $monthLtDate = date('Y-m-t', strtotime(date('Y-m-d')));
  $get_all_saved = "SELECT * FROM `user_coupons` WHERE `device_id`='" . $device_id . "' AND `scan_date` BETWEEN '" . $monthStDate . "' AND '" . $monthLtDate . "'";

  $execute = $dbh->query($get_all_saved);
  $saved_all_count = $execute->rowCount();

  $saved_item_list = $execute->fetchAll(PDO::FETCH_OBJ);

  $saved_amount = 0;
  
  if($saved_all_count > 0){
    // if there are saved coupons
    // calculate saved amount in dollars
    foreach ($saved_item_list as $saved) {
      if ($saved->scan_coupon_status == 4) {
          // get coupon value
          $saved_amount += $saved->val_usd;
      }
      else if ($saved->scan_coupon_status == 3) {
        // get coupon value
        $saved_amount += $saved->val_usd;
      }
      else if ($saved->scan_coupon_status == 2) {
        // get coupon value
        $saved_amount += (($saved->val_usd) / ($saved->total_used_times) );
      }
    }

    if($saved_amount >= $max_savings) {
      $apiResponse['response_code'] = 200;
      $apiResponse['response_data'] = ['is_limit_exceeded' => 1,'saved_amount' => $saved_amount, 'max_savings' => $max_savings];
      $apiResponse['response_msg'] = 'You have exceded saving limit';
    }
    else {
      $apiResponse['response_code'] = 200;
      $apiResponse['response_data'] = ['is_limit_exceeded' => 0,'saved_amount' => $saved_amount, 'max_savings' => $max_savings];
      $apiResponse['response_msg'] = 'You can save more';
    }

}
else {
  $apiResponse['response_code'] = 200;
  $apiResponse['response_data'] = ['is_limit_exceeded' => 0,'saved_amount' => $saved_amount, 'max_savings' => $max_savings];
  $apiResponse['response_msg'] = 'You can save more';
}

}
header('Content-Type: application/json');
echo json_encode($apiResponse);
