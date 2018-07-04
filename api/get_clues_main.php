<?php
date_default_timezone_set('Europe/London');
include('conn.php');
include('func/Converter.php');

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
        `places`.`contact_name`,`places`.`place_id` as store_id, `places`.`street_number`, `places`.`street_address`,`places`.`is_verified`, `places`.`verified_count`, `places`.`time_zone`,`places`.`latitude` as store_lat,`places`.`longitude` as store_lng,  `visible_now`,
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
        // | get promos available 
        // | if user has saved a coupon ar used a saved coupon remove promotion from list
        // | if coupon has expired shop add promo to list
        $tempAllPRomo = [];
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
            }
        }


        // | for all available promos 
        // | get coupons and pref coupon
        // | get remaining time 
        // | store address
        // | set currency
        $tempNearByPromos = [];
        foreach($tempAllPRomo as $tPromo) {

            // | get details
            $promo_id = $tPromo->promo_id;

            // get remaining time 
            $time_difference = 0;
            $diff = [];

            // | get system date time and create date object
            $now = date("Y-m-d H:i:s");
            $now_time = date_create($now);

            // | get promo details
            $promo_repeate = $tPromo->promo_repeat;
            $promo_repeate_value = trim($tPromo->promo_repeat_values);
            $promo_start_time = trim($tPromo->start_at);
            $promo_start_time_local = trim($tPromo->start_at_local);
            $promo_end_time = trim($tPromo->end_at);

            // create time 
            $time_p_st = time($promo_start_time);
            $time_p_st_local = time($promo_start_time_local);

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


                $stm = trim(str_replace($remove_chars, "", $promo_repeate_value));
                $list = explode(",", $stm);


                if(in_array($day_count, $list, TRUE)){
                    $temp = date("Y-m-d ". $promo_start_time);
                    $promo_start = date_create($temp);
                    $diff = date_diff($now_time, $promo_start);
                }

            }

            // $diff = [];
            if(sizeof($diff) > 0 ) {
                if($diff->invert == 0){
                    $total_in_miliseconds = ((((($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h) * 60 + $diff->i)*60 + $diff->s) * 1000);
                    $time_difference = $total_in_miliseconds;
                }

                // if($time_p_st > $time_p_st_local) {
                    
                // }
                // else {
                //     if($diff->invert == 1){
                //         $total_in_miliseconds = ((((($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h) * 60 + $diff->i)*60 + $diff->s) * 1000);
                //         $time_difference = $total_in_miliseconds;
                //     }
                // }
                
            }

            // | set time remaining | //
            $tPromo->time_remaining = $time_difference;

            // get place id
            $place_ids = $tPromo->place_id;
            $repstmt = trim(str_replace($remove_chars, ' ', $place_ids));
            $list_ids = explode(",", $repstmt);

            $st_id = $list_ids[0];

            // get store details
            $get_st = "SELECT * FROM `places` WHERE `place_id`=" . $st_id;
            $exceSt = $dbh->query($get_st);
            $st_det = $exceSt->fetchAll(PDO::FETCH_OBJ);

            // | Get store address
            $address = $st_det[0]->street_address;
            // country short
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

            // get all coupons 
            $sql5 = "SELECT * FROM `coupons`  WHERE `promo_id` =". $promo_id;
            $coops3 = $dbh->query($sql5);
            $all_coupons = $coops3->fetchAll(PDO::FETCH_OBJ);

            // set currency
            foreach($all_coupons as $coupon) {
                $coupon->currency = $curr;
            }

            // | set all coupons | // 
            $tPromo->all_coupon = $all_coupons;

            // get pref_coupon
            $sql3 = "SELECT * FROM `coupons` WHERE `promo_id` =" .$promo_id. " AND (`coupon_availabilty` > `count_occupied` OR `coupon_availabilty` = 'Unlimited') ORDER BY `coupon_id` ASC LIMIT 0,1";
            $coops = $dbh->query($sql3);
            $num_rows = $coops->rowCount();
            $pref_coupon = $coops->fetchAll(PDO::FETCH_OBJ);

            // | set currency | //
            $pref_coupon[0]->currency = $curr;

            // pref coupon id
            $pref_coupon_id = $pref_coupon[0]->coupon_id;
            // pref coupon level
            $pref_coupon_lvl = $pref_coupon[0]->coupon_level;

            // check if this has saved and expired
            $chkSvd = "SELECT * FROM `user_coupons` WHERE `device_id`='" . $device_id . "' AND `scan_promo_id`=". $promo_id . " AND `scan_coupon_id`=" . $pref_coupon_id . " AND `scan_coupon_status`=3";
            $runSQl = $dbh->query($chkSvd);
            $chkRows = $runSQl->rowCount();
            $chkDetails = $runSQl->fetchAll(PDO::FETCH_OBJ);

            if($chkRows > 0) {

                // if coupon level < 4
                // check other coupons for next best coupon
                if($pref_coupon_lvl < 4) {
                    // check all coupons
                    $t_pref_coupon = [];
                    for($x = $pref_coupon_lvl; $x < 4; $x++) {
                        $t_availability = $all_coupons[$x]->coupon_availabilty;
                        $t_occupied = $all_coupons[$x]->count_occupied;

                        if(($t_availability > $t_occupied) || ($t_availability == "Unlimited")) {
                            // if coupons are available
                            $t_pref_coupon = $all_coupons[$x];
                            break;
                        }
                    }

                    // add pref coupon 
                    $tPromo->pref_coupon = $t_pref_coupon;
                } 
                else {
                    $pref_coupon = [];
                    // add pref coupon 
                    $tPromo->pref_coupon = $pref_coupon;
                }

            }
            else {
                // if not saved 
                // add pref coupon 
                $tPromo->pref_coupon = $pref_coupon[0];
            }

            // if there is pref coupon add to list
            if(sizeof($tPromo->pref_coupon) > 0) {
                $tempNearByPromos[] = $tPromo;
            }
        
        }

        // $api_info['res'] = $tempNearByPromos;

        // | for all filtered promos 
        // | check for excluded coupons
        // | set pref coupons
        $result = [];

        // get server details
        $serverLocation = Converter::get_server_location();
        $ser_lat = $serverLocation['latitude'];
        $ser_lng = $serverLocation['longitude'];

        // get server offset
        $server_offset = Converter::get_time_zone($ser_lat, $ser_lng);

        foreach($tempNearByPromos as $nPromo) {
            // get pref coupon id, level and all coupons
            $nPrefCoupId = $nPromo->pref_coupon->coupon_id;
            $nPrefCoupLvl = $nPromo->pref_coupon->coupon_level;
            $nAllCoupons = $nPromo->all_coupon;
            $api_info['pref-ids'][] = $nPrefCoupId; 
            // get store details 
            $store_lat = $nPromo->store_lat;
            $store_lng = $nPromo->store_lng;
            
            // get store offset 
            $store_offset = Converter::get_time_zone($store_lat, $store_lng);

        
            // check for exclude 
            $chkPrefExclude = "SELECT * FROM `exclued_coupons` WHERE `device_id`='" . $device_id . "' AND `coupon_id`=" . $nPrefCoupId . " ORDER BY `id` ASC";
            $excChkPref = $dbh->query($chkPrefExclude);
            $chkPrefExclude = $excChkPref->rowCount();
            $prefExcludeDetails = $excChkPref->fetchAll(PDO::FETCH_OBJ);

            if($chkPrefExclude > 0) {
                // if excluded 
                // check last date time
                $getLastDate = $prefExcludeDetails[$chkPrefExclude - 1]->date;
                $lastDate = ($getLastDate . " 23:59:00");
                $lastDateTime = strtotime($lastDate);

                // get server time 
                $serverTime = Converter::get_server_time_by_store_time($lastDateTime, $store_offset, $server_offset);

                // now 
                $today = date('Y-m-d H:i:s');

                // create date objects 
                $serverDateObj = date_create($serverTime);
                $todayDateObj = date_create($today);
                
                $diffPref = date_diff($serverDateObj, $todayDateObj);
                $is_passed = 0;

                // check time difference 
                if(sizeof($diffPref) > 0){
                    if($diffPref->invert == 0){
                        $get_time_difference = ((((($diffPref->y * 365.25 + $diffPref->m * 30 + $diffPref->d) * 24 + $diffPref->h) * 60 + $diffPref->i) * 60 + $diffPref->s) * 1000);

                        if($get_time_difference > 0) {
                            $is_passed = 1;
                        }
                    }
                }

                if($is_passed == 1) {
                    $result[] = $nPromo;
                }
                else {
                    // get next best
                    $new_prep_coup = [];
                    if($nPrefCoupLvl < 4) {
                        for($y = $nPrefCoupLvl; $y < 4; $y++) {

                            // get coupon details
                            $t_cp_id = $nAllCoupons[$y]->coupon_id;
                            $tcp_available = $nAllCoupons[$y]->coupon_availabilty;
                            $tcp_occupied = $nAllCoupons[$y]->count_occupied;
    
                            // check for exclude
                            $chkNextExclude = "SELECT * FROM `exclued_coupons` WHERE `device_id`='" . $device_id . "' AND `coupon_id`=" . $t_cp_id . " ORDER BY `id` ASC";
                            $excNextExclude = $dbh->query($chkNextExclude);
                            $rowsNextExclude = $excNextExclude->rowCount();
                            $detailsNextExclude = $excNextExclude->fetchAll(PDO::FETCH_OBJ);
    
                            if($rowsNextExclude > 0) {
                                // if excluded
                                // check last date 
                                $getTLastDate = $detailsNextExclude[$rowsNextExclude - 1]->date;
                                $lastTDate = strtotime($getTLastDate . " 23:59:00");
                
                                // get server time 
                                $serverTTime = Converter::get_server_time_by_store_time($lastTDate, $store_offset, $server_offset);
                
                                // now 
                                $todayT = date('Y-m-d H:i:s');
    
                                // create date objects 
                                $serverTDateObj = date_create($serverTTime);
                                $todayTDateObj = date_create($todayT);
    
                                $diffPrefT = date_diff($serverTDateObj, $todayTDateObj);
                                $is_passed_t = 0;
    
                                // check time difference
                                if(sizeof($diffPrefT) > 0){
                                    if($diffPref->invert == 0){
                                        $get_time_difference = ((((($diffPrefT->y * 365.25 + $diffPrefT->m * 30 + $diffPrefT->d) * 24 + $diffPrefT->h) * 60 + $diffPrefT->i) * 60 + $diffPrefT->s) * 1000);
    
                                        if($get_time_difference > 0) {
                                            $is_passed_t = 1;
                                        }
                                    }
                                }
    
                
                                if($is_passed_t == 1) {
                                    $new_prep_coup = $nAllCoupons[$y];
                                    break;
                                }else {
                                    continue;
                                }
                            }
                            else {
                                // if not excluded
                                // check availability 
                                if(($tcp_available > $tcp_occupied) || ($tcp_available == "Unlimited")) {
                                    $new_prep_coup = $nAllCoupons[$y];
                                    break;
                                } else {
                                    continue;
                                }
                                
                            }
    
                        }
                    }
                    else {
                        $nPromo->pref_coupon = $new_prep_coup;
                        break;
                    }
                    

                    $nPromo->pref_coupon = $new_prep_coup;
                    if(sizeof($nPromo->pref_coupon) > 0) {
                        $result[] = $nPromo;
                    }
                    
                }
                

            }
            else {
                // if not excluded
                // add to final list
                $result[] = $nPromo;
            }

        }

        $api_info['promo_info'] = $result;
        
    }
    else {
        // if user is not in the system
        $api_info['response_msg'] = "device_not_found";
    }

}



$api_info['response_code'] = 200;

header('Content-Type: application/json');
echo json_encode($api_info);