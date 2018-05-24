<?php
include('conn.php');
include('func/PushNotification.php');

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $place_id = trim($_POST['place_id']);
    $device_id = trim($_POST['device_id']);

    // get player id by device
    $get_player = "SELECT * FROM `users_device_details` WHERE `device_id`='" . $device_id . "'";
    $exec = $dbh->query($get_player);
    $player_ids = $exec->fetchAll(PDO::FETCH_OBJ);

    $player_id = $player_ids[0]->player_id;

    // get store details
    $getSt = "SELECT * FROM `places` WHERE `place_id`=" . $place_id;
    $execST = $dbh->query($getSt);
    $storeDet = $execST->fetchAll(PDO::FETCH_OBJ);

    $store_name = $storeDet[0]->contact_name;

    // get re targeting coupons
    $get_re = "SELECT * FROM `retarget_coupons` WHERE `place_id`=" . $place_id . " AND `status` = 1 AND `geo_campaign` = 1";
    $execGetRe = $dbh->query($get_re);
    $re_coup = $execGetRe->fetchAll(PDO::FETCH_OBJ);

    // re target coupon id
    $re_coup_id = $re_coup[0]->coupon_id;

    // check if user has saved a coupon
    $check_saved = "SELECT * FROM `retarget_saved` WHERE `device_id`='" . $device_id . "' AND `place_id` = " . $place_id . " AND `coupon_id` =" . $re_coup_id;
    $execSvd  = $dbh->query($check_saved);
    $svd_rows = $execSvd->rowCount();

    if($svd_rows == 0) {

        // insert to saved
        $insert = "INSERT INTO `retarget_saved`(`place_id`,`coupon_id`,`device_id`,`is_push`,`created_at`,`updated_at`) VALUES (" . $place_id . "," . $re_coup_id. ",'" . $device_id . "',0,'" . date('Y-m-d H:i:s') . "','" . date('Y-m-d H:i:s') . "' )";
        $execInst = $dbh->query($insert);
        $insertRows = $execInst->rowCount();

        if($insertRows > 0) {
            // send the push
            $notification = "Hey there you have got a coupon from " . $store_name;
            $data = [];
            $devices = [$player_id];

            PushNotification::create_notification($notification, $data, $devices) ;
        }

    }

}
// header('Content-Type: application/json');
// echo json_encode($out);
?>
