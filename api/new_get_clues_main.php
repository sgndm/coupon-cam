<?php
date_default_timezone_set('Europe/London');
include('conn.php');

$api_info = [];
$api_info['promo_info'] = [];
$temp_nearby_coupons = [];
$remove_chars = ["[", "]", "\""];


$latitude   = trim($_POST['latitude']);
$longitude  = trim($_POST['longitude']);
$device_id  = trim($_POST['device_id']);
$radius = 0.5; // | 500m

if(empty($latitude)) {
    $api_info['response_msg'] = "latitude_empty";
}
else if(empty($longitude)){
    $api_info['response_msg'] = "longitude_empty";
}
else if(empty($device_id)){
    $api_info['response_msg'] = "device_id_empty";
}
else{

    // | get user details
    $sql1 = "SELECT * FROM `users_device_details` WHERE `device_id`='" . $device_id . "'";
    $res1 = $dbh->query($sql1);
    $row1 = $res1->rowCount();
    $device_details = $res1->fetchAll(PDO::FETCH_OBJ);

    if($row1 > 0) {
        // if user in the system 
        // | get nearby coupons all
        $sql2 = "SELECT
        `promos`.`promo_id`,`promos`.`place_id`,
        `promos`.`add_date`, `promos`.`promo_name`,
        `promos`.`promo_length`, `promos`.`advance_warning`,
        `promos`.`is_shown`, `start_at`,`start_at_local`, `end_at`, `end_at_local`,
        `promo_length`, `advance_warning`,
        `promo_repeat`,  `promo_repeat_values`,
        `places`.`contact_name`,`places`.`place_id` as store_id, `places`.`street_number`, `places`.`street_address`,`places`.`is_verified`, `places`.`verified_count`, `places`.`time_zone`,  `visible_now`,
        promo_locations.lat_code as latitude, promo_locations.lng_code as longitude,
        (((acos(sin(($latitude*pi()/180)) * sin((promo_locations.lat_code*pi()/180))
        + cos(($latitude*pi()/180)) * cos((promo_locations.lat_code*pi()/180))
        * cos((($longitude - promo_locations.lng_code)*pi()/180))))
        * 180/pi())*60*1.1515*1.609344)
        as distance FROM `promo_locations`
        LEFT JOIN `promos` ON `promo_locations`.`promo_id` = `promos`.`promo_id`
        LEFT JOIN `places` ON `promo_locations`.`store_id` = `places`.`place_id`

        WHERE `promos`.`status` = 1
        GROUP BY `promos`.`promo_id`
        HAVING distance <= $radius ORDER BY distance ASC";
        $res2 = $dbh->query($sql2);
        $nearbyPromos = $res2->fetchAll(PDO::FETCH_OBJ);

        $tempAllPRomo = [];

        // | for every nearby promo
        // | get promos available 
        // | if user has saved a coupon ar used a saved coupon remove promotion from list
        // | if coupon has expired shop add promo to list
        foreach($nearbyPromos as $promo){

            // check if coupon has promo has saved or not
            $checkSaved = "SELECT * FROM `user_coupons` WHERE `device_id`='" . $device_id . "' AND `scan_promo_id`=". $promo->promo_id;
            $execSVC = $dbh->query($checkSaved);
            $checkSavedRows = $execSVC->rowCount();
            $detailsCheckSaved = $execSVC->fetchAll(PDO::FETCH_OBJ);

            if($checkSavedRows > 0) {
                
                $isSavedOrRedeemed = 0;
                foreach($detailsCheckSaved as $saved) {
                    if(($saved->scan_coupon_status == 4) || ($saved->scan_coupon_status == 2)) {
                        $isSavedOrRedeemed = 1;
                    }
                }

                if($isSavedOrRedeemed == 0) {
                    $tempAllPRomo[] = $promo;
                }

            } else {
                $tempAllPRomo[] = $promo;
                $api_info['res'] = $tempAllPRomo;
            }
        }

        // $api_info['res'] = $tempAllPRomo;

        // | for all available promos 
        // | get coupons
        foreach($tempAllPRomo as $tPromo) {

            // | get details
            $promo_id = $tPromo->promo_id;

            // get place id
            $place_ids = $promo->place_id;
            $repstmt = trim(str_replace($remove_chars, ' ', $place_ids));
            $list_ids = explode(",", $repstmt);

            $st_id = $list_ids[0];

            // get store details
            $get_st = "SELECT * FROM `places` WHERE `place_id`=" . $st_id;
            $exceSt = $dbh->query($get_st);
            $st_det = $exceSt->fetchAll(PDO::FETCH_OBJ);

            $country_short = $st_det[0]->country_short;

            // get currency label
            $curr = "$";
            if($country_short == "GB") {
                $curr = "£";
            }
            else if($country_short == "NZ") {
                $curr = "$";
            }
            else if($country_short == "CA") {
                $curr = "C$";
            }
            else if($country_short == "AU") {
                $curr = "A$";
            }
            else {
                $curr = "$";
                
            }

            
        }
    }
    else {
        // if user is not in the system
        $api_info['response_msg'] = "device_not_found";
    }

}



$api_info['response_code'] = 200;

header('Content-Type: application/json');
echo json_encode($api_info);