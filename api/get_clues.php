<?php
/*
	| for pre launch
*/

include('conn.php');

$api_info = [];
$api_info['promo_info'] = [];


$latitude   = trim($_POST['latitude']);
$longitude  = trim($_POST['longitude']);
$device_id  = trim($_POST['device_id']);
$radius = 1; // | 1000m

// | get nearby stores (all)
$sql2 = "SELECT
            `places`.`contact_name`,`places`.`store_promo`,`places`.`place_id` as store_id,`places`.`store_description`, `places`.`street_number`, `places`.`street_address`,`places`.`is_verified`, `places`.`verified_count`,`places`.`store_photo`,`places`.`store_ar`,`places`.`store_marker`,`places`.`is_give_away`, `places`.`time_zone`, `places`.`qr_code`,
             places.latitude as latitude, places.longitude as longitude,
            (((acos(sin(($latitude*pi()/180)) * sin((places.latitude*pi()/180))
            + cos(($latitude*pi()/180)) * cos((places.latitude*pi()/180))
            * cos((($longitude - places.longitude)*pi()/180))))
            * 180/pi())*60*1.1515*1.609344)
            as distance FROM `places`
            WHERE `places`.`status` = 1
            ORDER BY distance ASC";
             // removed (HAVING distance <= $radius);
$res2 = $dbh->query($sql2);
$nearbyStores = $res2->fetchAll(PDO::FETCH_OBJ);


// | get saved coupons
$getsvd = "SELECT `place_id` FROM `pre_luanch_saved` WHERE `device_id`='" . $device_id . "'";
$execute = $dbh->query($getsvd);
$save_stores = $execute->fetchAll(PDO::FETCH_OBJ);
$saved_rows = $execute->rowCount();

$saved_store_array = [];

foreach($save_stores as $svStore){
	$tempID = $svStore->place_id;
	array_push($saved_store_array, $tempID);
}

	foreach($nearbyStores as $store){

        $st_num = $store->street_number;
        $st_add = $store->street_address;

        $address = '';

        if(strlen($st_num) > 0) {
            $address = $st_num . "," . $st_add;
        } else {
            $address = $st_add;
        }

		$storeID = $store->store_id;


		// | output
		$temp = [
			'promo_id' => 0,
			'promo_name' => "",
			'promo_length' => "",
			'advance_warning' => '',
			'start_at' => 0,
			'end_at' => 0,
			'promo_repeat' => 0,
			'promo_repeat_values' => '',
			'place_id' => $store->store_id,
			'is_verified' => $store->is_verified,
			'verified_count' => $store->verified_count,
			'contact_name' => $store->contact_name,
            'store_promo' => $store->store_promo,
			'address' => $address,
			'store_description' => $store->store_description,
			'latitude' => $store->latitude,
			'longitude' => $store->longitude,
			'distance' => $store->distance,
			'pref_coupon' => $store,
			'all_coupon' => array(),
			'time_remaining' => 0,
            'store_marker' => $store->store_marker,
            'qr_code' => $store->qr_code
		];

    if($store->is_give_away == 0) {
      if($saved_rows > 0) {
        if(in_array($storeID, $saved_store_array)){
          continue;
        } else {
          $api_info['promo_info'][] = $temp;
        }
      } else {
       $api_info['promo_info'][] = $temp;
     }
    }


	}


header('Content-Type: application/json');
echo json_encode($api_info);
