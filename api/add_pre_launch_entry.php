<?php
include("conn.php");
include("func/PushNotification.php");

$apiResponse  = array('response_code' => '','response_data' => '','response_msg' => '');

if($_SERVER['REQUEST_METHOD'] == 'POST') {

	// | Get Data From Request |
	$place_id = trim($_POST["place_id"]);
	$device_id = trim($_POST["device_id"]);
	$is_shared = trim($_POST["is_shared"]);
	$is_referral = trim($_POST["is_referral"]);
	$ref_device_id = trim($_POST["ref_device_id"]);

	// If is referral is 1 add entry for referral device_id
	if($is_referral == 1) {
        
        // check referral device id
        if(!($device_id == $ref_device_id)){

            // add new entry
            $sql1 = "INSERT INTO `pre_luanch_saved`(`device_id`, `place_id`,`saved_date`,`is_shared`,`is_referral`) VALUES ('" . $ref_device_id . "'," . $place_id . ",'" . date('Y-m-d'). "'," . $is_shared . "," . $is_referral . ")";
            $res1 = $dbh->query($sql1);
            $rows1 = $res1->rowCount();

            // get player id for ref_device
            $get_ref_sql = "SELECT `player_id` FROM `users_device_details` WHERE `device_id`='" . $ref_device_id . "'";
            $res_player = $dbh->query($get_ref_sql);
            $get_player = $res_player->fetchAll(PDO::FETCH_OBJ);
            $player_id = $get_player[0]->player_id;

            // get count today
            $get_ref_count = "SELECT COUNT(*) as ref_count_today FROM `pre_luanch_saved` WHERE `device_id`='" . $ref_device_id . "' AND `is_referral`=1 AND `saved_date`='" . date('Y-m-d') . "'";
            $res_get_ref_count = $dbh->query($get_ref_count);
            $get_details_ref = $res_get_ref_count->fetchAll(PDO::FETCH_OBJ);
            $ref_count_today = $get_details_ref[0]->ref_count_today;

            // get count all
            $get_ref_count_all = "SELECT COUNT(*) as ref_count_all FROM `pre_luanch_saved` WHERE `device_id`='" . $ref_device_id . "' AND `is_referral`=1 ";
            $res_get_ref_count_all = $dbh->query($get_ref_count_all);
            $get_details_ref_all = $res_get_ref_count_all->fetchAll(PDO::FETCH_OBJ);
            $ref_count_all = $get_details_ref_all[0]->ref_count_all;


            // send push notification for ref device
            $notification = "Congratulations! Today " . $ref_count_today . " people clicked on your shared link! You got another " . $ref_count_all . " chances to win at #RedFriday";
            $devices = array($player_id);
            $data = '';

            PushNotification::create_notification($notification, $data, $devices);

        }


	}

	// | if user has shared
	if($is_shared == 1) {
		// add new entry
		$sql2 = "INSERT INTO `pre_luanch_saved`(`device_id`,`place_id`,`saved_date`,`is_shared`,`is_referral`) VALUES ('" . $device_id . "'," . $place_id . ",'" . date('Y-m-d'). "'," . $is_shared . "," . $is_referral . ")";
		$res2 = $dbh->query($sql2);
		$rows2 = $res2->rowCount();


		if($rows2 > 0 ){
			$apiResponse['response_code'] = 200;
			$apiResponse['response_data'] = array('is_reserved' => 1);
			$apiResponse['response_msg'] = "You have successfully shared this item";
		} else {
			$apiResponse['response_code'] = 200;
			$apiResponse['response_data'] = array('is_reserved' => 0);
			$apiResponse['response_msg'] = "Unable to shared this item";
		}
	} else {

		// | check saved
		$getSql = "SELECT * FROM `pre_luanch_saved` WHERE `device_id`='" . $device_id . "' AND `place_id`='" . $place_id . "'";
		$getSaved = $dbh->query($getSql);
		$savedStores = $getSaved->fetchAll(PDO::FETCH_OBJ);
		$saveCount = $getSaved->rowCount();

		if($saveCount > 0) {
			$apiResponse['response_code'] = 200;
			$apiResponse['response_data'] = array();
			$apiResponse['response_msg'] = "You have already reserved this item";
		} else {

			// add to pre launch table
			$sql2 = "INSERT INTO `pre_luanch_saved`(`device_id`, `place_id`,`saved_date`) VALUES ('" . $device_id . "'," . $place_id . ",'" . date('Y-m-d'). "')";
			$res2 = $dbh->query($sql2);
			$rows2 = $res2->rowCount();


			if($rows2 > 0 ){
				$apiResponse['response_code'] = 200;
				$apiResponse['response_data'] = array('is_reserved' => 1);
				$apiResponse['response_msg'] = "You have successfully reserved this item";
			} else {
				$apiResponse['response_code'] = 200;
				$apiResponse['response_data'] = array('is_reserved' => 0);
				$apiResponse['response_msg'] = "Unable to reserve this item";
			}
		}

	}



}


header('Content-Type: application/json');
echo json_encode($apiResponse);
