<?php
include("conn.php");

$apiResponse  = array('response_code' => '','response_data' => array(),'response_msg' => '');

$radius = 1; // 1 km

if($_SERVER['REQUEST_METHOD'] == 'POST') {

	$device_id = trim($_POST['device_id']);
	$latitude = trim($_POST['latitude']);
	$longitude = trim($_POST['longitude']);

	// geo coupons
    $geo_coupons = [];

	// get stores nearby
    $get_nearby_stores = "SELECT `place_id`,(((acos(sin(($latitude*pi()/180)) * sin((latitude*pi()/180))
            + cos(($latitude*pi()/180)) * cos((latitude*pi()/180))
            * cos((($longitude - longitude)*pi()/180))))
            * 180/pi())*60*1.1515*1.609344)
            as distance  FROM `places` WHERE `status`=1 HAVING distance <= $radius ORDER BY distance ASC";

    $execGetStores = $dbh->query($get_nearby_stores);
    $nearByRows = $execGetStores->rowCount();
    $nearByStores = $execGetStores->fetchAll(PDO::FETCH_OBJ);

    // foreach nearby stores
    foreach ($nearByStores as $store) {
        // store id
        $n_store_id = $store->place_id;

        // check for re-targeted coupons
        $checkCoupon = "SELECT * FROM `retarget_coupons` WHERE `status`=1 AND `geo_campaign`=1 AND `place_id`=" . $n_store_id;
        $execCoup = $dbh->query($checkCoupon);
        $coupRows = $execCoup->rowCount();
        $reCoupons = $execCoup->fetchAll(PDO::FETCH_OBJ);

        if($coupRows > 0) {
            $t_coup_id = $reCoupons[0]->coupon_id;

            // check if user has saved this
            $checkReSaved = "SELECT * FROM `retarget_saved` WHERE `device_id`='" . $device_id . "' AND `place_id`=" . $n_store_id . " AND `coupon_id`=" . $t_coup_id;
            $execReSvd = $dbh->query($checkReSaved);
            $reSvdRows = $execReSvd->rowCount();

            // check
            if($reSvdRows == 0) {
                $geo_coupons[] = $reCoupons[0];
            }
        }
    }


    // return nearby geo coupons
    $apiResponse['response_data']['geo_coupons'] = $geo_coupons;

    // end of nearby geo coupons

    // geo coupons saved
    // get saved geo coupons | order by distance
    $getReSaved = "SELECT `retarget_saved`.*,`retarget_saved`.`place_id` as store_id,`places`.`contact_name`,(((acos(sin(($latitude*pi()/180)) * sin((places.latitude*pi()/180))
            + cos(($latitude*pi()/180)) * cos((places.latitude*pi()/180))
            * cos((($longitude - places.longitude)*pi()/180))))
            * 180/pi())*60*1.1515*1.609344)
            as distance, `retarget_coupons`.* FROM `retarget_saved` LEFT JOIN `places` ON `places`.`place_id`=`retarget_saved`.`place_id` LEFT JOIN `retarget_coupons` ON `retarget_coupons`.`coupon_id` = `retarget_saved`.`coupon_id` WHERE `retarget_saved`.`device_id`='".$device_id."' ORDER BY distance ASC";

    $exGetReSvd = $dbh->query($getReSaved);
    $retargetSaved = $exGetReSvd->fetchAll(PDO::FETCH_OBJ);

    $apiResponse['response_data']['geo_coupon_saved'] = $retargetSaved;
    // end for geo coupons saved

    // output saved
    $out_saved = [];

    // get stores by distance
    $get_store_ids = "SELECT DISTINCT(`user_coupons`.`place_id`) as store_id,`places`.*,(((acos(sin(($latitude*pi()/180)) * sin((places.latitude*pi()/180))
            + cos(($latitude*pi()/180)) * cos((places.latitude*pi()/180))
            * cos((($longitude - places.longitude)*pi()/180))))
            * 180/pi())*60*1.1515*1.609344)
            as distance FROM `user_coupons` LEFT JOIN `places` ON `places`.`place_id`=`user_coupons`.`place_id` WHERE `user_coupons`.`device_id`='".$device_id."' ORDER BY distance ASC";

    $execStores = $dbh->query($get_store_ids);
    $getRows = $execStores->rowCount();
    $store_ids = $execStores->fetchAll(PDO::FETCH_OBJ);

    // for all stores
    // get saved coupons
    foreach ($store_ids as $store) {
        // get store id
        $t_store_id = $store->store_id;
        $t_store_name = $store->contact_name;
        $t_store_address = $store->address;
        $t_store_qr_code = $store->qr_code;
        $t_store_qr_image = $store->qr_image;
        $t_store_distance = $store->distance;

        // get saved coupon
        $sql = "SELECT `user_coupons`.*,`user_coupons`.`place_id` as store_id,`promos`.*,`coupons`.* FROM `user_coupons` LEFT JOIN `promos` ON `promos`.`promo_id`=`user_coupons`.`scan_promo_id` LEFT JOIN `coupons`ON `coupons`.`coupon_id`=`user_coupons`.`scan_coupon_id` WHERE `user_coupons`.`device_id`='".$device_id."' AND `user_coupons`.`place_id`=" . $t_store_id;

        $res = $dbh->query($sql);
        $rows = $res->rowCount();
        $saved_coupons = $res->fetchAll(PDO::FETCH_OBJ);

        if($rows > 0) {
            foreach($saved_coupons as $coupons) {
                $store_id = (int)$coupons->store_id;
                $promo_id = (int)$coupons->scan_promo_id;

                // | get location
                $sql2 = "SELECT * FROM `promo_locations` WHERE `store_id`=" . $store_id . " AND `promo_id`=" . $promo_id;
                $res2 = $dbh->query($sql2);
                $rows2 = $res2->rowCount();
                $lat_lng = $res2->fetchAll(PDO::FETCH_OBJ);

                // store lat long
                $lat = $lat_lng[0]->lat_code;
                $lng = $lat_lng[0]->lng_code;

                // set data to array
                $coupons->latitude = $lat;
                $coupons->longitude = $lng;
                $coupons->store_name = $t_store_name;
                $coupons->store_address = $t_store_address;
                $coupons->qr_code = $t_store_qr_code;
                $coupons->qr_image = $t_store_qr_image;
                $coupons->distance = $t_store_distance;

                $out_saved[] = $coupons;

            }
        }


    }

    // out put saved
//    $apiResponse['response_data']['saved_coupons'] = $out_saved;
    $apiResponse['response_data'] = $out_saved;

    // end of saved coupons



    if(sizeof($apiResponse['response_data']) > 0) {
        $apiResponse['response_code'] = 200;
        $apiResponse['response_msg'] = "These are your coupons";
    }
    else {
        $apiResponse['response_code'] = 200;
        $apiResponse['response_data'] = array();
        $apiResponse['response_msg'] = "No saved coupons";
    }







}

header('Content-Type: application/json');
echo json_encode($apiResponse);
