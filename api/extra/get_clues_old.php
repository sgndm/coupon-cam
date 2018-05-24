<?php
include('conn.php');


// GET RECORDS
/*
$latitude   = isset($_POST['latitude'])?$_POST['latitude']:'6.880069';
$longitude  = isset($_POST['longitude'])?$_POST['longitude']:'79.87979';
$device_id  = isset($_POST['device_id'])?$_POST['device_id']:'42419038-E336-4395-82BD-574CDBDAF3F3';*/

$latitude   = trim($_POST['latitude']);
$longitude  = trim($_POST['longitude']);
$device_id  = trim($_POST['device_id']);
$radius     = 1; /// 1km

/*
$myfile = fopen("newfile.txt", "a") or die("Unable to open file!");
$txt = $device_id."---". $latitude . "---" . $longitude ."\n";
fwrite($myfile, $txt);
fclose($myfile);*/

$arr = array();


if (!$latitude ) {
	$arr['response_code']	= '201';
	$arr['response_data'] 	= array();
	$arr['response_msg'] 	= 'Latitude is blank';
	echo json_encode($arr);
} elseif (!$longitude ) {
	$arr['response_code']	= '202';
	$arr['response_data'] 	= array();
	$arr['response_msg'] 	= 'Longitude is blank';
	echo json_encode($arr);
} elseif (!$device_id ) {
	$arr['response_code']	= '204';
	$arr['response_data'] 	= array();
	$arr['response_msg'] 	= 'Device id is blank';
	echo json_encode($arr);
}

// | check for instant coupons | //
$sqlncc = "SELECT * FROM `user_coupons` WHERE `device_id`='" . $device_id . "' AND `scan_coupon_status`=1";
$resnn = $dbh->query($sqlncc);
$rowsssss = $resnn->rowCount();
$insCoupos = $resnn->fetchAll(PDO::FETCH_OBJ);

$has_instant_coup = 0;
$instCount = 0;
if($rowsssss > 0) {
	foreach($insCoupos as $insCoup) {
		$reserved_date = $insCoup->scan_date;
		$stm = explode("-", $reserved_date);
		$rY = $stm[0];
		$rM = $stm[1];
		
		$Y = date('Y');
		$m = date('m');
		
		if(($rY == $Y) && ($rM == $m)) {
			// |  | //
			$instCount += 1;
		}
	}
	
	if($instCount > 0) {
		$has_instant_coup = 0;
	} else {
		$has_instant_coup = 1;
	}
} else {
	$has_instant_coup = 1;
}

// Get saved coupons
$getsvd = "SELECT `scan_promo_id` FROM `user_coupons` WHERE `device_id`='" . $device_id . "'";
$execute = $dbh->query($getsvd);
$save_coupons = $execute->fetchAll(PDO::FETCH_OBJ);
$saved_rows = $execute->rowCount();


$sql = "SELECT 
            `promos`.`promo_id`,`promos`.`place_id`, 
            `promos`.`add_date`, `promos`.`promo_name`, 
            `promos`.`promo_length`, `promos`.`advance_warning`, 
            `promos`.`is_shown`, `pre_launch_clue`, `start_at`, `end_at`, 
            `promo_length`, `advance_warning`, `warning_start_time`, 
            `promo_repeat`,  `promo_repeat_values`,
            `places`.`contact_name`,`places`.`place_id` as store_id,`places`.`is_verified`,`places`.`verified_count`, `places`.`time_zone`,  `visible_now`, 
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
$nn = $dbh->query($sql);
$results = $nn->fetchAll(PDO::FETCH_OBJ);
$api_info = array();
foreach ($results as $key => $value) {
            $sql = "SELECT coupon_id,coupon_title,coupon_availabilty,count_occupied, coupon_information, terms_conditions, coupon_photo,photo,coupon_model,add_date,estimated_value,coupon_level
						FROM coupons "
                    . "WHERE promo_id =".$value->promo_id."  AND "
                    . "(coupon_availabilty > count_occupied OR coupon_availabilty = 'Unlimited')"
                    . "ORDER BY coupon_id ASC LIMIT 0,1";
            $coops = $dbh->query($sql);
            $num_rows = $coops->rowCount();
        if($num_rows > 0){
            $coupons = $coops->fetch(PDO::FETCH_OBJ);
        }else{
            $sql = "SELECT coupon_id,coupon_title,coupon_availabilty,count_occupied, coupon_information, terms_conditions, coupon_photo,photo,coupon_model,add_date,estimated_value,coupon_level
						FROM coupons "
                    . "WHERE promo_id =".$value->promo_id."  AND "
                    . "coupon_availabilty = 'Unlimited'"
                    . "ORDER BY coupon_id ASC LIMIT 0,1";
            $coops = $dbh->query($sql);
            $coupons = $coops->fetch(PDO::FETCH_OBJ);
        }
        
            $sql = "SELECT coupon_id,coupon_title,coupon_availabilty,count_occupied, coupon_information, terms_conditions, coupon_photo,photo,coupon_model,add_date,estimated_value,coupon_level FROM coupons "
                    . "WHERE promo_id =".$value->promo_id;
            $all_coops = $dbh->query($sql);
            //$coupons = $all_coops->fetchAll(PDO::FETCH_OBJ);
			
			$sqln = "SELECT * FROM `places` WHERE `latitude`=" . $value->latitude . " AND `longitude`=" . $value->longitude . "";
			$resnn = $dbh->query($sqln);
			$resnnnn = $resnn->fetchAll(PDO::FETCH_OBJ);
			
			// | get advanced warning value
			$advanced_warning = $value->advance_warning;
			$time_difference = 0;
			$diff = [];
			
			// | get system date time and create date object
			$now = date("Y-m-d H:i:s");
			$now_time = date_create($now);
			
			// | if adwanced warning enabled
			if($advanced_warning == 1){
				
				// | get promo details
				$promo_repeate = $value->promo_repeat;
				$promo_repeate_value = trim($value->promo_repeat_values);
				$promo_start_time = trim($value->start_at);
				
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
					
					if(($name == 'Saturday') || ($name == 'Sunday') ){
						
					}
					
				}
				// | if saturday to sunday
				else if($promo_repeate == "Weekend"){
					
				} 
				// | if custom date
				else {
					
				}
				
				
				if(sizeof($diff) > 0 ) {
					
					if($diff->invert == 0){
						$total_in_miliseconds = ((((($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h) * 60 + $diff->i)*60 + $diff->s) * 1000);
						$time_difference = $total_in_miliseconds;
					}
				}
				
			}
			
			
        
		
	$xx = 	[
				'promo_id' => $value->promo_id,
				'place_id' => $value->store_id,
                'is_verified' => $value->is_verified,
                'verified_count' => $value->verified_count,
				'add_date' => $value->add_date,
				'promo_name' => $value->promo_name,
				'promo_length' => $value->promo_length,
				'advance_warning' => $value->advance_warning,
				'start_at' => $value->start_at,
				'end_at' => $value->end_at,
				'warning_start_time' => $value->warning_start_time,
				'promo_repeat' => $value->promo_repeat,
				'promo_repeat_values' => $value->promo_repeat_values,
				'contact_name' => $value->contact_name,
				'latitude' => $value->latitude,
				'longitude' => $value->longitude,
				'distance' => $value->distance,
				'pref_coupon' => $coupons,
				'all_coupon' => $all_coops->fetchAll(PDO::FETCH_OBJ),
				//'diff' => $diff,
				'time_remaining' => $time_difference,
				'now' => $now_time,
				'promo_start' => $promo_start,
				'date_name' => $name
			];
        
		if($saved_rows > 0) {
			foreach($save_coupons as $svCp){
				$svPromoId = $svCp->scan_promo_id;
				
				if( ($value->promo_id) == $svPromoId ){
					continue;
				} else {
					$api_info['promo_info'][] = $xx;
				}
			}
		} else {
			
			$api_info['promo_info'][] = $xx;
		}

}

$api_info['has_instant_coup'] = $has_instant_coup;

header('Content-Type: application/json');
    echo json_encode($api_info);

