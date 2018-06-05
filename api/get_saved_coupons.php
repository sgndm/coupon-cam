<?php
include("conn.php");

$apiResponse  = array('response_code' => '','response_data' => [],'response_msg' => '');


if($_SERVER['REQUEST_METHOD'] == 'POST') {

	$device_id = trim($_POST['device_id']);
    $items = array();
    $getSaved = "SELECT `place_id` as store_id, COUNT(*) as saved_count FROM `pre_luanch_saved` WHERE `device_id`='" . $device_id . "' GROUP BY `place_id` ORDER BY `place_id`";
    $res = $dbh->query($getSaved);
	$rows = $res->rowCount();
	$saved_coupons = $res->fetchall(PDO::FETCH_OBJ);

    // get details
    foreach($saved_coupons as $saved) {
        $store_id = $saved->store_id;
        $saved_count = $saved->saved_count;

        $getDetails = "SELECT `pre_luanch_saved`.*,`places`.* FROM `pre_luanch_saved` LEFT JOIN `places` ON `places`.`place_id`=`pre_luanch_saved`.`place_id` WHERE `pre_luanch_saved`.`place_id`='".$store_id."' AND `pre_luanch_saved`.`device_id` = '" . $device_id . "'";

        $res2 = $dbh->query($getDetails);
        $rows2 = $res2->rowCount();
        $saved_details = $res2->fetchall(PDO::FETCH_OBJ);

        $is_referral =0;
        $is_shared=0;
        $is_redeemed=0;

        foreach($saved_details as $storeObj) {
            if($storeObj->is_shared == 1){
                $is_shared=$storeObj->is_shared;
            }

            if($storeObj->is_redeemed == 1){
                $is_redeemed=$storeObj->is_redeemed;
            }

            if($storeObj->is_referral == 1){
                $is_referral=$storeObj->is_referral;
            }

        }

        //$saved_details[0]->count = $saved_count;
        $temp = [
           'store_id' => $store_id,
           'saved_count' => $saved_count,
            'is_shared' => $is_shared,
            'is_redeemed' => $is_redeemed,
            'is_referral' => $is_referral,
            'store_details' => $saved_details
        ];

        $items[] = $temp;
    }

	if($rows > 0){
		$apiResponse['response_code'] = 200;
		$apiResponse['response_data'] = $items;
		$apiResponse['response_msg'] = "saved coupons";
	} else {
		$apiResponse['response_code'] = 200;
		$apiResponse['response_data'] = array();
		$apiResponse['response_msg'] = "No saved coupons";
	}


}

header('Content-Type: application/json');
echo json_encode($apiResponse);
