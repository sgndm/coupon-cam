<?php
include('conn.php');
$apiResponse  = array('response_code' => '','response_data' => '','response_msg' => '');


if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $device_id = trim($_POST['device_id']);
    $player_id = trim($_POST['player_id']);
    $dev_type = trim($_POST['device_type']);
    $country = trim($_POST['country']);
    $current_version = trim($_POST['current_version']);
    $lat = trim($_POST['latitude']);
    $lng = trim($_POST['longitude']);

    // returnn value
    $is_pre_launch = 0;
    $app_version = 0;
    $is_main_ready = 0;
    $remaining_time = 0;
    $is_new_user = 0;

    // get setting values from db
    $getSettings = "SELECT * FROM `app_settings`";
    $exApp = $dbh->query($getSettings);
    $app_settings = $exApp->fetchAll(PDO::FETCH_OBJ);

    foreach ($app_settings as $setting) {
        if($setting->setting_name == "pre_launch") {
            $is_pre_launch = $setting->setting;
        }
        if($setting->setting_name == "app_version") {
            $app_version = $setting->setting;
        }
        if($setting->setting_name == "is_main_ready") {
            $is_main_ready = $setting->setting;

            $get_main_launch = date('Y-m-d H:i:s', strtotime($setting->date));
            $main_launch = date_create($get_main_launch);

            $get_now = date('Y-m-d H:i:s');
            $now = date_create($get_now);

            $diff = date_diff($now, $main_launch);

            if(sizeof($diff) > 0 ) {
                if($diff->invert == 0){
                    $total_in_miliseconds = ((((($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h) * 60 + $diff->i)*60 + $diff->s) * 1000);

                    $remaining_time = $total_in_miliseconds;
                }
            }

        }

    }

    if($is_main_ready == 0) {
        $remaining_time = 0;
    }


    if( $dev_type == 'ios'){
        $device_type = 'I';
    } elseif($dev_type == 'Android'){
        $device_type = 'A';
    }elseif($dev_type == 'Windows'){
        $device_type = 'W';
    }

    // // get wordings
    $getWordingsSql = "SELECT * FROM `wordings`";
    $excGetWord = $dbh->query($getWordingsSql);
    $wordings = $excGetWord->fetchAll(PDO::FETCH_OBJ);


    /// | get give away stores
    $getStores = "SELECT * FROM `places` WHERE `is_give_away` = 1";
    $excGetStores = $dbh->query($getStores);
    $rowsGeStores = $excGetStores->rowCount();
    $Stores = $excGetStores->fetchAll(PDO::FETCH_ASSOC);

    // $giveAwayStore = [];
    // if($rowsGeStores > 0) {
    //     $giveAwayStore = $Stores[0];
    // }

    $sql1 = "SELECT * FROM `users_device_details` WHERE `device_id` = '" . $device_id . "'";
    $res1 = $dbh->query($sql1);
    $rows1 = $res1->rowCount();
    $result1 = $res1->fetchAll(PDO::FETCH_ASSOC);

    if($rows1 > 0) {

        $sql2 = "UPDATE `users_device_details` SET `last_open_ip`='" . $_SERVER['REMOTE_ADDR'] . "',`last_open_date`='" . date('Y-m-d H:i:s') . "', `country`='" . $country . "', `app_version`=" . $current_version . ", `player_id`='" . $player_id . "',`lat`='".$lat."', `lng`='".$lng."' WHERE `device_id`='" . $device_id . "' ";
        $res2 = $dbh->query($sql2);
        $rows2 = $res2->rowCount();

        // update device location table
        $upDL = "UPDATE `device_locations` SET `latitude`='" . $lat . "',`longitude`='" . $lng . "',`last_updated`='" . date('Y-m-d H:i:s') . "' WHERE `device_id`='" . $device_id . "' ";
        $execUPDL = $dbh->query($upDL);

        $is_new_user = 0;

        if($rows2 > 0) {
            $apiResponse['response_code']		= '200';
            $apiResponse['response_data'] 	= array('is_pre_launch' => $is_pre_launch, 'app_version'=> $app_version, 'is_main_ready' =>$is_main_ready, 'remaining_time' => $remaining_time ,'is_new_user' => $is_new_user, 'wordings' => $wordings);
            $apiResponse['response_msg'] 		= 'Device details updated successfully';
        } else {
            $apiResponse['response_code']		= '200';
            $apiResponse['response_data'] 	= array('is_pre_launch' => $is_pre_launch, 'app_version'=> $app_version, 'is_main_ready' =>$is_main_ready, 'remaining_time' => $remaining_time, 'wordings' => $wordings);
            $apiResponse['response_msg'] 		= 'Failed updating device details';
        }

    }
    else {

        $sql3 = "INSERT INTO `users_device_details`(`device_id`, `player_id`, `device_type`, `first_open_ip`, `last_open_ip`, `last_open_date`, `country`,`app_version`,`lat`,`lng`) VALUES ('" . $device_id . "','" . $player_id . "','" . $device_type . "','" . $_SERVER['REMOTE_ADDR'] . "','" . $_SERVER['REMOTE_ADDR'] . "','" . date('Y-m-d H:i:s') . "','" . $country . "'," . $current_version . ",'".$lat."','".$lng."')";
        $res3 = $dbh->query($sql3);
        $rows3 = $res3->rowCount();

        $is_new_user = 1;

        // insert to device location table
        $insDL = "INSERT INTO `device_locations`(`device_id`, `latitude`, `longitude`, `last_updated`) VALUES ('" . $device_id . "','" . $lat . "','" . $lng . "','" . date('Y-m-d H:i:s') . "')";
        $execIDL = $dbh->query($insDL);

        if($rows3 > 0){
            $apiResponse['response_code']		= '200';
            $apiResponse['response_data'] 	= array('is_pre_launch' => $is_pre_launch, 'app_version'=> $app_version, 'is_main_ready' =>$is_main_ready, 'remaining_time' => $remaining_time ,'is_new_user' => $is_new_user, 'wordings' => $wordings);
            $apiResponse['response_msg'] 		= 'Device registration successful';
        } else {
            $apiResponse['response_code']		= '200';
            $apiResponse['response_data'] 	= array('is_pre_launch' => $is_pre_launch, 'app_version'=> $app_version, 'is_main_ready' =>$is_main_ready, 'remaining_time' => $remaining_time, 'wordings' => $wordings );
            $apiResponse['response_msg'] 		= 'Device registration failed';
        }

    }

    $apiResponse['response_data']['has_saved_red_promo'] = 0;

    // get pre launch promo
    $getPre = "SELECT * FROM `red_friday_promos` WHERE `is_pre_launch`=1 AND `status`=1";
    $execPre = $dbh->query($getPre);
    $rowsPre = $execPre->rowCount();
    $prePromos = $execPre->fetchAll(PDO::FETCH_OBJ);

    if($rowsPre > 0){
        $red_promo_id = $prePromos[0]->promo_id;
        $apiResponse['response_data']['red_friday_promo'] = $prePromos;

        // check saved for this divice and red promo
        $checkSVD = "SELECT * FROM `user_coupons` WHERE `device_id`='" . $device_id ."' AND `red_promo_id`=" . $red_promo_id . " AND `is_red_friday` = 1";
        $exec_chksvd = $dbh->query($checkSVD);
        $totalSaved = $exec_chksvd->rowCount();

        if($totalSaved > 0) {
            $apiResponse['response_data']['has_saved_red_promo'] = 1;
        }

    }
    else {
        $apiResponse['response_data']['red_friday_promo'] = [];
    }


    if($is_main_ready == 0) {
        $apiResponse['response_data']['red_friday_promo'] = [];
    }



}

header('Content-Type: application/json');
echo json_encode($apiResponse);
