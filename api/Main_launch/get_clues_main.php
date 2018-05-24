<?php
/*
	| Check subscribed or not 
	| Check advance_warning enabled or not 
	| if advance_warning enabled show remaining time | else hide until promo start 
	| Hide saved promos
	| Hide expired promos
*/

include('../conn.php');

$api_info = [];


$latitude   = trim($_POST['latitude']);
$longitude  = trim($_POST['longitude']);
$device_id  = trim($_POST['device_id']);
$radius = 0.5; // | 500m

// | get user details
$sql1 = "SELECT * FROM `users_device_details` WHERE `device_id`='" . $device_id . "'";
$res1 = $dbh->query($sql1);
$row1 = $res1->rowCount();
$device_details = $res1->fetchAll(PDO::FETCH_OBJ);

// | get subscriber details
$is_subscribed = trim($device_details[0]->is_subscribed);

// | change radius if user has subscribed
if($is_subscribed == 1){
	$radius = 0.85;  // | 850m
}

// | get saved coupons
$getsvd = "SELECT `scan_promo_id` FROM `user_coupons` WHERE `device_id`='" . $device_id . "'";
$execute = $dbh->query($getsvd);
$save_coupons = $execute->fetchAll(PDO::FETCH_OBJ);
$saved_rows = $execute->rowCount();

	

// | get nearby coupons (all)
$sql2 = "SELECT 
            `promos`.`promo_id`,`promos`.`place_id`, 
            `promos`.`add_date`, `promos`.`promo_name`, 
            `promos`.`promo_length`, `promos`.`advance_warning`, 
            `promos`.`is_shown`, `pre_launch_clue`, `start_at`, `end_at`, 
            `promo_length`, `advance_warning`, `warning_start_time`, 
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

// | for every nearby promo
foreach($nearbyPromos as $promo){
	
	// | get details
	$promo_id = $promo->promo_id;
	
	// | get pref coupon
	$sql3 = "SELECT coupon_id,coupon_title,coupon_availabilty,count_occupied, coupon_information, terms_conditions, coupon_photo,photo,coupon_model,add_date,estimated_value,coupon_level
					FROM coupons "
				. "WHERE promo_id =".$promo_id."  AND "
				. "(coupon_availabilty > count_occupied OR coupon_availabilty = 'Unlimited')"
				. "ORDER BY coupon_id ASC LIMIT 0,1";
		$coops = $dbh->query($sql3);
		$num_rows = $coops->rowCount();
	if($num_rows > 0){
		$pref_coupon = $coops->fetch(PDO::FETCH_OBJ);
	}else{
		$sql4 = "SELECT coupon_id,coupon_title,coupon_availabilty,count_occupied, coupon_information, terms_conditions, coupon_photo,photo,coupon_model,add_date,estimated_value,coupon_level
					FROM coupons "
				. "WHERE promo_id =".$promo_id."  AND "
				. "coupon_availabilty = 'Unlimited'"
				. "ORDER BY coupon_id ASC LIMIT 0,1";
		$coops2 = $dbh->query($sql4);
		$pref_coupon = $coops2->fetch(PDO::FETCH_OBJ);
	}
	
	// | Get All Coupons
	$sql5 = "SELECT coupon_id,coupon_title,coupon_availabilty,count_occupied, coupon_information, terms_conditions, coupon_photo,photo,coupon_model,add_date,estimated_value,coupon_level FROM coupons "
			. "WHERE promo_id =".$promo_id;
	$coops3 = $dbh->query($sql5);
	$all_coupons = $coops3->fetchAll(PDO::FETCH_OBJ);
	
	
	// | get advanced warning value
	$advanced_warning = $promo->advance_warning;
	$time_difference = 0;
	$diff = [];

	// | get system date time and create date object
	$now = date("Y-m-d H:i:s");
	$now_time = date_create($now);

	// | if adwanced warning enabled
	if($advanced_warning == 1){
		
		// | get promo details
		$promo_repeate = $promo->promo_repeat;
		$promo_repeate_value = trim($promo->promo_repeat_values);
		$promo_start_time = trim($promo->start_at);
		$promo_end_time = trim($promo->end_at);
		
		$promo_start = '';
		$name = '';
		
		// | if one rime promo
		if($promo_repeate == "Date"){
			$temp = date($promo_repeate_value . " " . $promo_start_time);
			$promo_start = date_create($temp);
			$diff = date_diff($now_time, $promo_start);

		} 
		// | if a daily promo
		else if($promo_repeate == "Daily"){
			$temp = date("Y-m-d ". $promo_start_time);
			$promo_start = date_create($temp);
			$diff = date_diff($now_time, $promo_start);
			
		} 
		// | if monday to friday
		else if($promo_repeate == "Week"){
			// | get day (name)
			$name = date("l");
			
			if(!($name == 'Saturday') || !($name == 'Sunday') ){
				$temp = date("Y-m-d ". $promo_start_time);
				$promo_start = date_create($temp);
				$diff = date_diff($now_time, $promo_start);
			}
			
		}
		// | if saturday to sunday
		else if($promo_repeate == "Weekend"){
			// | get day (name)
			$name = date("l");
			
			if(($name == 'Saturday') || ($name == 'Sunday') ){
				$temp = date("Y-m-d ". $promo_start_time);
				$promo_start = date_create($temp);
				$diff = date_diff($now_time, $promo_start);
			}
		} 
		// | if custom date
		else {
			// | get day (name)
			$name = date("l");
			$day_count = 0;
			
			if($name == 'Monday'){
				$day_count = '1';
			}
			else if($name == 'Tuesday'){
				$day_count = '2';
			}
			else if($name == 'Wednesday'){
				$day_count = '3';
			}
			else if($name == 'Thursday'){
				$day_count = '4';
			}
			else if($name == 'Friday'){
				$day_count = '5';
			}
			else if($name == 'Saturday'){
				$day_count = '6';
			}
			else if($name == 'Sunday'){
				$day_count = '7';
			}
			
			$remove_chars = ["[", "]", "\""];
			$stm = trim(str_replace($remove_chars, "", $promo_repeate_value));
			$list = explode(",", $stm);
			
			
			if(in_array($day_count, $list, TRUE)){
				$temp = date("Y-m-d ". $promo_start_time);
				$promo_start = date_create($temp);
				$diff = date_diff($now_time, $promo_start);
			}
			
		}
		
		
		if(sizeof($diff) > 0 ) {
			
			if($diff->invert == 0){
				$total_in_miliseconds = ((((($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h) * 60 + $diff->i)*60 + $diff->s) * 1000);
				$time_difference = $total_in_miliseconds;
			}
		}
		
	}
	
	// | Get store address
	$address = $promo->street_number . " " . $promo->street_address;
	
	// | output
	$temp = [
		'promo_id' => $promo_id,
		'add_date' => $promo->add_date,
		'promo_name' => $promo->promo_name,
		'promo_length' => $promo->promo_length,
		'advance_warning' => $promo->advance_warning,
		'start_at' => $promo->start_at,
		'end_at' => $promo->end_at,
		'promo_repeat' => $promo->promo_repeat,
		'promo_repeat_values' => $promo->promo_repeat_values,
		'place_id' => $promo->store_id,
		'is_verified' => $promo->is_verified,
		'verified_count' => $promo->verified_count,
		'contact_name' => $promo->contact_name,
		'address' => $address,
		'latitude' => $promo->latitude,
		'longitude' => $promo->longitude,
		'distance' => $promo->distance,
		'pref_coupon' => $pref_coupon,
		'all_coupon' => $all_coupons,
		'time_remaining' => $time_difference
	];
	
	
	
	// | check saved coupons
	if($saved_rows > 0 ){
		foreach($save_coupons as $saved){
			
			$saved_promo_id = $saved->scan_promo_id;
			
			// | if promo is not in saved list
			if( !($promo_id == $saved_promo_id)) {
				
				if($advanced_warning == 1){
					// | if advanced warning enabled
					
					$promo_end_at = date($promo_end_time);
					$now_time = date("H:i:s");
					
					if($promo_end_at > $now_time ){
						// | if not expired add to list
						$api_info['promo_info'][] = $temp;	
					}
					
				} else {
					// | if advanced warnings not enabled
					$promo_start_at = date($promo_start_time);
					$promo_end_at = date($promo_end_time);
					$now_time = date("H:i:s");
					$temp['now'] = $now_time;
					$temp['st'] = $promo_start_at;
					$temp['end'] = $promo_end_at;
					if($promo_start_at == $now_time){
						// | start time == time now add to list
						$api_info['promo_info'][] = $temp;
					} 
					else if( ($promo_start_at < $now_time) && ($promo_end_at > $now_time )){
						// | if not expired add to list
						$api_info['promo_info'][] = $temp;
					}
				}
					
				
			}
			
		}
	} else {
		if($advanced_warning == 1){
			// | if advanced warning enabled
			
			$promo_end_at = date($promo_end_time);
			$now_time = date("H:i:s");
			
			if($promo_end_at > $now_time ){
				// | if not expired add to list
				$api_info['promo_info'][] = $temp;	
			}
			
		} else {
			// | if advanced warnings not enabled
			$promo_start_at = date($promo_start_time);
			$promo_end_at = date($promo_end_time);
			$now_time = date("H:i:s");
			$temp['now'] = $now_time;
			$temp['st'] = $promo_start_at;
			$temp['end'] = $promo_end_at;
			if($promo_start_at == $now_time){
				// | start time == time now add to list
				$api_info['promo_info'][] = $temp;
			} 
			else if( ($promo_start_at < $now_time) && ($promo_end_at > $now_time )){
				// | if not expired add to list
				$api_info['promo_info'][] = $temp;
			}
		}
	}
	
	
}



header('Content-Type: application/json');
echo json_encode($api_info);