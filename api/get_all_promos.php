<?php

date_default_timezone_set('Europe/London');
include('conn.php');

$device_id  = trim($_POST['device_id']);


$api_info['promo_info'] = [];

// | get nearby coupons (all)
$sql2 = "SELECT `promos`.*, `places`.*, `promo_locations`.`lat_code` as latitude, `promo_locations`.`lng_code` as longitude FROM `promo_locations` LEFT JOIN `promos` ON `promo_locations`.`promo_id` = `promos`.`promo_id` LEFT JOIN `places` ON `promo_locations`.`store_id` = `places`.`place_id` WHERE `promos`.`status` = 1 GROUP BY `promos`.`promo_id`";
$res2 = $dbh->query($sql2);
$nearbyPromos = $res2->fetchAll(PDO::FETCH_OBJ);

foreach($nearbyPromos as $promo){

    // | get details
    $promo_id = $promo->promo_id;
    
    // | get pref coupon
	$sql3 = "SELECT * FROM coupons "
    . "WHERE promo_id =".$promo_id."  AND "
    . "(coupon_availabilty > count_occupied OR coupon_availabilty = 'Unlimited')"
    . "ORDER BY coupon_id ASC LIMIT 0,1";
    $coops = $dbh->query($sql3);
    $num_rows = $coops->rowCount();
    if($num_rows > 0){
    $pref_coupon = $coops->fetch(PDO::FETCH_OBJ);
    }else{
    $sql4 = "SELECT * FROM coupons "
        . "WHERE promo_id =".$promo_id."  AND "
        . "coupon_availabilty = 'Unlimited'"
        . "ORDER BY coupon_id ASC LIMIT 0,1";
    $coops2 = $dbh->query($sql4);
    $pref_coupon = $coops2->fetch(PDO::FETCH_OBJ);
    }

    $promo->pref_coupon = $pref_coupon;

    // check if this promo has saved before
	$checkSaved = "SELECT * FROM `user_coupons` WHERE `device_id`='" . $device_id . "' AND `scan_promo_id`=". $promo->promo_id;
	$execSVC = $dbh->query($checkSaved);
    $checkSavedRows = $execSVC->rowCount();
   
    
    if(!($checkSavedRows > 0)) {
        $api_info['promo_info'][] = $promo;
    }

}

//check excluded coupons
$excludedCouponsQuery = "SELECT * FROM `exclued_coupons` WHERE `device_id`='".$device_id."'";
// file_put_contents('php://stderr',print_r($checkExcluded, TRUE));
$execSVC = $dbh->query($excludedCouponsQuery);
// file_put_contents('php://stderr',print_r($execSVC, TRUE));
$excludedCoupons = $execSVC;
// file_put_contents('php://stderr',print("getAllPromosLog1"));
// file_put_contents('php://stderr',print_r($checkExcludedRows, TRUE));
error_log("getAllPromosErrorLog1");
file_put_contents('php://stderr',print_r($excludedCoupons, TRUE));
file_put_contents('php://stderr',print_r($excludedCoupons->count, TRUE));

foreach($excludedCoupons as $coupon){
    error_log("getAllPromosErrorLog2");
    file_put_contents('php://stderr',print_r($coupon, TRUE));
    $api_info['excluded_coupons'][] = $coupon;
}

$api_info['response_code'] = 200;
$api_info['response_msg'] = "all_promos";


header('Content-Type: application/json');
echo json_encode($api_info);