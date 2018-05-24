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

  $sql = "SELECT `promo_locations`.`store_id` AS store_id,`promo_locations`.`lat_code` AS latitude,`promo_locations`.`lng_code` AS longitude,`promos`.* FROM `promo_locations` LEFT JOIN `promos` ON `promos`.`promo_id`=`promo_locations`.`promo_id` WHERE `promo_locations`.`store_id`=" . $place_id;

	$res = $dbh->query($sql);
	$rows = $res->rowCount();
	$get_promo_details = $res->fetchAll(PDO::FETCH_OBJ);

  $out = [];
  if($rows > 0) {

    foreach ($get_promo_details as $key => $promo) {
      $out[$promo->promo_name] = $promo;
    }


    // send push
    $notification = "Hey There are some awesome promos nearby, check them out..";
    $data = $out;
    $devices = [$player_id];

    PushNotification::create_notification($notification, $data, $devices) ;

  }

}
// header('Content-Type: application/json');
// echo json_encode($out);
?>
