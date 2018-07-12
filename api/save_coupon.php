<?php
include("conn.php");
include('func/Converter.php');

$apiResponse  = array('response_code' => '','response_data' => array(),'response_msg' => '');

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    // | Get Data From Request |
    $place_id = trim($_POST["place_id"]);
    $device_id = trim($_POST["device_id"]);
    $coupon_id = trim($_POST["coupon_id"]);

    // get app settings
    $get_appset = "SELECT * FROM `app_settings` WHERE `setting_name`='saving_limit'";
    $execLimit = $dbh->query($get_appset);
    $settings = $execLimit->fetchAll(PDO::FETCH_OBJ);

    $app_save_limit = $settings[0]->setting;


    if(empty($device_id)) {

        $apiResponse['response_code'] = '202';
        $apiResponse['response_data'] = array(
            'device_id' => $device_id
        );
        $apiResponse['response_msg'] = 'Device id is blank';

        // | Validate coupon id
    }
    else if(empty($place_id)) {

        $apiResponse['response_code'] = '202';
        $apiResponse['response_data'] = array(
            'place_id' => $place_id
        );
        $apiResponse['response_msg'] = 'place id is blank';

        // | Validate coupon id
    }
    else if(empty($coupon_id)) {

        $apiResponse['response_code'] = '203';
        $apiResponse['response_data'] = array(
            'coupon_id' => $coupon_id
        );
        $apiResponse['response_msg'] = 'Coupon id is blank ';

        // | if all are verified
    }
    else {

        // get coupon details
        $sql2 = "SELECT * FROM `coupons` WHERE `coupon_id` = " . $coupon_id;
        $res2 = $dbh->query($sql2);
        $rows2 = $res2->rowCount();
        $result2 = $res2->fetchAll(PDO::FETCH_ASSOC);

        if($rows2 > 0) {

            // available count
            $available_count = $result2[0]['coupon_availabilty'];
            // occupied count
            $count_occupied = $result2[0]['count_occupied'];
            // coupon value
            $coupon_value = $result2[0]['estimated_value'];
            // promo id
            $promo_id = $result2[0]['promo_id'];

            // coupon level
            $coupon_lvl = $result2[0]['coupon_level'];


            // | get user details
            $getUsrSql = "SELECT * FROM `users_device_details` WHERE `device_id`='" . $device_id . "'";
            $getUsr = $dbh->query($getUsrSql);
            $device_details = $getUsr->fetchAll(PDO::FETCH_OBJ);

            // | get subscriber details
            $is_subscribed = trim($device_details[0]->is_subscribed);

            // | check if store has verified | //
            $sqln = "SELECT * FROM `places` WHERE `place_id` = " . $place_id;
            $resn = $dbh->query($sqln);
            $rowsn = $resn->rowCount();
            $resultn = $resn->fetchAll(PDO::FETCH_ASSOC);

            // store verification
            $is_verified = $resultn[0]['is_verified'];
            // get country of store
            $country = $resultn[0]['country_short'];


            // | check if coupon has reserved before by this device
            $sql3 = "SELECT * FROM `user_coupons` WHERE `scan_promo_id`=".$promo_id." AND `scan_coupon_id`=".$coupon_id." AND `device_id`='".$device_id."' ";
            $res3 = $dbh->query($sql3);
            $rows3 = $res3->rowCount();

            if($rows3 > 0) {

                $apiResponse['response_code'] = '206';
                $apiResponse['response_data'] = array(
                    'promo_id' => $promo_id,
                    'coupon_id' => $coupon_id,
                    'place_id' => $place_id,
                    'is_verified' => $is_verified
                );
                $apiResponse['response_msg'] = 'You have already reserved this item';

            }
            else {

                if( ($available_count == "Unlimited") || ( ((int)$available_count) > ((int)$count_occupied) ) ){
                    // if coupons are available

                    $val_USD = 0;
                    $val_CAD = 0;
                    $val_NZD = 0;
                    $val_AUD = 0;
                    $val_UK = 0;

                    $get_values = Converter::get_values_for_countries($country, $coupon_value);

                    $val_USD = $get_values['val_usd'];
                    $val_NZD = $get_values['val_nzd'];
                    $val_AUD = $get_values['val_aud'];
                    $val_CAD = $get_values['val_cad'];
                    $val_UK = $get_values['val_uk'];

                    if ($is_subscribed == 0) {
                        // if user has not subscribed
                        // check for save limit
                        $monthStDate = date('Y-m-01');
                        $monthLtDate = date('Y-m-t', strtotime(date('Y-m-d')));
                        $get_all_saved = "SELECT * FROM `user_coupons` WHERE `device_id`='" . $device_id . "' AND `scan_date` BETWEEN '" . $monthStDate . "' AND '" . $monthLtDate . "'";

                        $execute = $dbh->query($get_all_saved);
                        $saved_all_count = $execute->rowCount();

                        $saved_item_list = $execute->fetchAll(PDO::FETCH_OBJ);

                        $saved_amount = 0;
                        if($saved_all_count > 0) {
                            // if there are saved coupons
                            // calculate saved amount in dollars
                            foreach ($saved_item_list as $saved) {
                                if ($saved->scan_coupon_status == 4) {
                                    // get coupon value
                                    $saved_amount += $saved->val_usd;
                                } else if ($saved->scan_coupon_status == 3) {
                                    // get coupon value
                                    $saved_amount += $saved->val_usd;
                                } else if ($saved->scan_coupon_status == 2) {
                                    // get coupon value
                                    $saved_amount += (($saved->val_usd) / ($saved->total_used_times));
                                }
                            }

                            /*// check if limit has exceded
                            $apiResponse['response_data']['saved_amount'] = $saved_amount;
                            if ($saved_amount >= $app_save_limit) {
                                $apiResponse['response_code']		= '200';
                                $apiResponse['response_data'] 	= array(
                                    'promo_id' => $promo_id,
                                    'coupon_id' => $coupon_id,
                                    'place_id' => $place_id,
                                    'is_verified' => $is_verified
                                );
                                $apiResponse['response_msg'] = 'Oops You have exceded your savings limit';
                            }
                            else if( ($saved_amount + $val_USD) > $app_save_limit) {
                                $apiResponse['response_code']		= '200';
                                $apiResponse['response_data'] 	= array(
                                    'promo_id' => $promo_id,
                                    'coupon_id' => $coupon_id,
                                    'place_id' => $place_id,
                                    'is_verified' => $is_verified
                                );
                                $apiResponse['response_msg'] = 'Oops You have exceded your savings limit';
                            }
                            else {*/

                            $insert = "INSERT INTO `user_coupons`(`scan_promo_id`,`scan_coupon_id`,`device_id`,`scan_coupon_status`,`scan_date`,`val_usd`,`val_cad`,`val_nzd`,`val_aud`,`val_pound`,`place_id`) VALUES(" . $promo_id ."," . $coupon_id . ",'" . $device_id . "',4,'" . date('Y-m-d') . "', " . $val_USD . "," . $val_CAD . "," . $val_NZD . "," . $val_AUD . ", " . $val_UK . "," . $place_id . ")";

                            $execute_q = $dbh->query($insert);
                            $rowsInsert = $execute_q->rowCount();

                            // new occupied count
                            $new_ocupied_count = $count_occupied + 1;
                            //
                            // update coupons table
                            $sql5 = "UPDATE `coupons` SET `count_occupied`='" . $new_ocupied_count . "' WHERE `coupon_id` = " . $coupon_id;
                            $res5 = $dbh->query($sql5);
                            $rows5 = $res5->rowCount();

                            if(($rowsInsert > 0) && ($rows5 > 0)) {

                                // add record for stats
                                $add_stat = "INSERT INTO `promo_stats`(`place_id`,`promo_id`,`coupon_id`,`device_id`,`created_at`) VALUES(" . $place_id . "," . $promo_id . ",". $coupon_id .",'" . $device_id . "','" . date('Y-m-d') . "')";
                                $exec = $dbh->query($add_stat);
                                $stRows = $exec->rowCount();

                                $apiResponse['response_code'] = '200';
                                $apiResponse['response_data'] = array(
                                    'promo_id' => $promo_id,
                                    'coupon_id' => $coupon_id,
                                    'place_id' => $place_id,
                                    'is_verified' => $is_verified
                                );

                                if($is_verified == 1) {
                                    $apiResponse['response_msg'] = 'Congratulations! You have been reserved the coupon successfully';
                                } else {
                                    $apiResponse['response_msg'] = 'saved_from_not_verified_store';
                                }


                            } else {

                                $apiResponse['response_code'] = '200';
                                $apiResponse['response_data'] = array(
                                    'promo_id' => $promo_id,
                                    'coupon_id' => $coupon_id,
                                    'place_id' => $place_id,
                                    'is_verified' => $is_verified
                                );
                                $apiResponse['response_msg'] = 'Oops! Something went wrong. You were unable to reserve the coupon!!';

                            }

                            // }


                        }
                        else {
                            // if user hasn't saved any coupons this month
                            $insert = "INSERT INTO `user_coupons`(`scan_promo_id`,`scan_coupon_id`,`device_id`,`scan_coupon_status`,`scan_date`,`val_usd`,`val_cad`,`val_nzd`,`val_aud`,`val_pound`,`place_id`) VALUES(" . $promo_id ."," . $coupon_id . ",'" . $device_id . "',4,'" . date('Y-m-d') . "', " . $val_USD . "," . $val_CAD . "," . $val_NZD . "," . $val_AUD . ", " . $val_UK . "," . $place_id . ")";

                            $execute_q = $dbh->query($insert);
                            $rowsInsert = $execute_q->rowCount();

                            // new occupied count
                            $new_ocupied_count = $count_occupied + 1;
                            //
                            // update coupons table
                            $sql5 = "UPDATE `coupons` SET `count_occupied`='" . $new_ocupied_count . "' WHERE `coupon_id` = " . $coupon_id;
                            $res5 = $dbh->query($sql5);
                            $rows5 = $res5->rowCount();

                            if(($rowsInsert > 0) && ($rows5 > 0)) {

                                // add record for stats
                                $add_stat = "INSERT INTO `promo_stats`(`place_id`,`promo_id`,`coupon_id`,`device_id`,`created_at`) VALUES(" . $place_id . "," . $promo_id . "," . $coupon_id .",'" . $device_id . "','" . date('Y-m-d') . "')";
                                $exec = $dbh->query($add_stat);
                                $stRows = $exec->rowCount();

                                $apiResponse['response_code'] = '200';
                                $apiResponse['response_data'] = array(
                                    'promo_id' => $promo_id,
                                    'coupon_id' => $coupon_id,
                                    'place_id' => $place_id,
                                    'is_verified' => $is_verified
                                );

                                if($is_verified == 1) {
                                    $apiResponse['response_msg'] = 'Congratulations! You have been reserved the coupon successfully';
                                } else {
                                    $apiResponse['response_msg'] = 'saved_from_not_verified_store';
                                }


                            } else {

                                $apiResponse['response_code'] = '200';
                                $apiResponse['response_data'] = array(
                                    'promo_id' => $promo_id,
                                    'coupon_id' => $coupon_id,
                                    'place_id' => $place_id,
                                    'is_verified' => $is_verified
                                );
                                $apiResponse['response_msg'] = 'Oops! Something went wrong. You were unable to reserve the coupon!!';

                            }
                        }
                    }
                    else {
                        // if user has subscribed
                        $insert = "INSERT INTO `user_coupons`(`scan_promo_id`,`scan_coupon_id`,`device_id`,`scan_coupon_status`,`scan_date`,`val_usd`,`val_cad`,`val_nzd`,`val_aud`,`val_pound`,`place_id`) VALUES(" . $promo_id ."," . $coupon_id . ",'" . $device_id . "',4,'" . date('Y-m-d') . "', " . $val_USD . "," . $val_CAD . "," . $val_NZD . "," . $val_AUD . ", " . $val_UK . "," . $place_id . ")";

                        $execute_q = $dbh->query($insert);
                        $rowsInsert = $execute_q->rowCount();

                        // new occupied count
                        $new_ocupied_count = $count_occupied + 1;
                        //
                        // update coupons table
                        $sql5 = "UPDATE `coupons` SET `count_occupied`='" . $new_ocupied_count . "' WHERE `coupon_id` = " . $coupon_id;
                        $res5 = $dbh->query($sql5);
                        $rows5 = $res5->rowCount();

                        if(($rowsInsert > 0) && ($rows5 > 0)) {

                            // add record for stats
                            $add_stat = "INSERT INTO `promo_stats`(`place_id`,`promo_id`,`coupon_id`,`device_id`,`created_at`) VALUES(" . $place_id . "," . $promo_id . "," . $coupon_id . ",'" . $device_id . "','" . date('Y-m-d') . "')";
                            $exec = $dbh->query($add_stat);
                            $stRows = $exec->rowCount();

                            $apiResponse['response_code']		= '200';
                            $apiResponse['response_data'] 	= array(
                                'promo_id' => $promo_id,
                                'coupon_id' => $coupon_id,
                                'place_id' => $place_id,
                                'is_verified' => $is_verified
                            );

                            if($is_verified == 1) {
                                $apiResponse['response_msg'] = 'Congratulations! You have been reserved the coupon successfully';
                            } else {
                                $apiResponse['response_msg'] = 'saved_from_not_verified_store';
                            }


                        } else {

                            $apiResponse['response_code'] = '200';
                            $apiResponse['response_data'] = array(
                                'promo_id' => $promo_id,
                                'coupon_id' => $coupon_id,
                                'place_id' => $place_id,
                                'is_verified' => $is_verified
                            );
                            $apiResponse['response_msg'] = 'Oops! Something went wrong. You were unable to reserve the coupon!!';

                        }
                    }

                }
                else {
                    // if coupons are not available
                    // get next best available
                    // save it


                    // get server details
                    $serverLocation = Converter::get_server_location();
                    $ser_lat = $serverLocation['latitude'];
                    $ser_lng = $serverLocation['longitude'];

                    // get server offset
                    $server_offset = Converter::get_time_zone($ser_lat, $ser_lng);

                    // get store lat lng
                    $get_lat_lng = "SELECT * FROM `places` WHERE `place_id`=" . $place_id;
                    $excGetST = $dbh->query($get_lat_lng);
                    $getDet = $excGetST->fetchAll(PDO::FETCH_OBJ);

                    $store_lat = $getDet[0]->latitude;
                    $store_lng = $getDet[0]->longitude;

                    // get store offset
                    $store_offset = Converter::get_time_zone($store_lat, $store_lng);

                    // get all coupons
                    // get all other coupons
                    $get_other_coupons = "SELECT * FROM `coupons` WHERE `promo_id`=" . $promo_id;
                    $execAll = $dbh->query($get_other_coupons);
                    $all_coupons = $execAll->fetchAll(PDO::FETCH_OBJ);
                    $rowsAll = $execAll->rowCount();

                    $next_best_coupon_id = 0;
                    if($coupon_lvl < 4) {
                        $t_best_coupon = 0;
                        for($x = $coupon_lvl; $x < 4; $x++) {
                            // next coupon id
                            $t_n_coupon_id = $all_coupons[$x]->coupon_id;
                            $t_availability = $all_coupons[$x]->coupon_availabilty;
                            $t_occuepied = $all_coupons[$x]->count_occupied;

                            // check availability
                            if(($t_availability > $t_occuepied) || ($t_availability == "Unlimited")) {
                                // if available
                                // check for saved
                                $chkSaved2 = "SELECT * FROM `user_coupons` WHERE `scan_coupon_id`=" . $t_n_coupon_id . " And `device_id`='" . $device_id . "'";
                                $excSvd2 = $dbh->query($chkSaved2);
                                $svdRows2 = $excSvd2->rowCount();

                                if($svdRows2 > 0) {
                                    // if user has saved
                                    continue;
                                }
                                else {
                                    // if coupon hasn't saved
                                    // check for exclude
                                    // check if this lvl excluded
                                    $checkExcluded = "SELECT * FROM `exclued_coupons` WHERE `device_id`='" . $device_id . "' AND `coupon_id`=" . $t_n_coupon_id . " ORDER BY `id` ASC";
                                    $executeCkeck = $dbh->query($checkExcluded);
                                    $rowsCheck = $executeCkeck->rowCount();
                                    $resExcludeCheck = $executeCkeck->fetchAll(PDO::FETCH_OBJ);

                                    if($rowsCheck > 0) {
                                        // if excluded
                                        // check date
                                        // check last excluded time
                                        $get_last_n  =  ($resExcludeCheck[$rowsCheck - 1]->created_at);
                                        $last_n = strtotime($get_last_n . " 23:59:00");

                                        // get server time
                                        $serverTime_n = Converter::get_server_time_by_store_time($last_n, $store_offset, $server_offset);

                                        // now
                                        $today_n = date('Y-m-d H:i:s');

                                        // create date objects
                                        $serverDateObjN = date_create($serverTime_n);
                                        $todayDateObjN = date_create($today_n);

                                        $diffPref_n = date_diff($serverDateObjN, $todayDateObjN);
                                        $is_passed_n = 0;

                                        // check time difference
                                        if(sizeof($diffPref_n) > 0){
                                            if($diffPref_n->invert == 0){
                                                $get_time_difference = ((((($diffPref_n->y * 365.25 + $diffPref_n->m * 30 + $diffPref_n->d) * 24 + $diffPref_n->h) * 60 + $diffPref_n->i) * 60 + $diffPref_n->s) * 1000);

                                                if($get_time_difference > 0) {
                                                    $is_passed = 1;
                                                }
                                            }
                                        }

                                        if($is_passed = 1) {
                                            $t_best_coupon = $t_n_coupon_id;
                                            break;
                                        }
                                        else {
                                            // if still excluded
                                            continue;
                                        }

                                    }
                                    else {

                                        $t_best_coupon = $t_n_coupon_id;
                                        break;
                                    }
                                }
                            }
                            else {
                                // if not available
                                continue;
                            }
                        }

                        $next_best_coupon_id = $t_best_coupon;


                    }

                    if($next_best_coupon_id > 0) {

                        // get coupon details
                        // get coupon details
                        $getNewCoup = "SELECT * FROM `coupons` WHERE `coupon_id` = " . $coupon_id;
                        $execNew = $dbh->query($getNewCoup);
                        $newRows = $execNew->rowCount();
                        $newCoupon = $execNew->fetchAll(PDO::FETCH_ASSOC);

                        $next_best_value = $newCoupon[0]['estimated_value'];
                        $next_best_available_count = $newCoupon[0]['coupon_availabilty'];
                        $next_best_ocupied_count = $newCoupon[0]['count_occupied'];

                        $val_USD = 0;
                        $val_CAD = 0;
                        $val_NZD = 0;
                        $val_AUD = 0;
                        $val_UK = 0;

                        $get_values = Converter::get_values_for_countries($country, $next_best_value);

                        $val_USD = $get_values['val_usd'];
                        $val_NZD = $get_values['val_nzd'];
                        $val_AUD = $get_values['val_aud'];
                        $val_CAD = $get_values['val_cad'];
                        $val_UK = $get_values['val_uk'];

                        $insert = "INSERT INTO `user_coupons`(`scan_promo_id`,`scan_coupon_id`,`device_id`,`scan_coupon_status`,`scan_date`,`val_usd`,`val_cad`,`val_nzd`,`val_aud`,`val_pound`,`place_id`) VALUES(" . $promo_id ."," . $next_best_coupon_id . ",'" . $device_id . "',4,'" . date('Y-m-d') . "', " . $val_USD . "," . $val_CAD . "," . $val_NZD . "," . $val_AUD . ", " . $val_UK . "," . $place_id . ")";

                        $execute_q = $dbh->query($insert);
                        $rowsInsert = $execute_q->rowCount();

                        // new occupied count
                        $new_next_best_ocupied_count = $next_best_ocupied_count + 1;
                        //
                        // update coupons table
                        $sql5 = "UPDATE `coupons` SET `count_occupied`='" . $new_next_best_ocupied_count . "' WHERE `coupon_id` = " . $next_best_coupon_id;
                        $res5 = $dbh->query($sql5);
                        $rows5 = $res5->rowCount();

                        if(($rowsInsert > 0) && ($rows5 > 0)) {

                            // add record for stats
                            $add_stat = "INSERT INTO `promo_stats`(`place_id`,`promo_id`,`coupon_id`,`device_id`,`created_at`) VALUES(" . $place_id . "," . $promo_id . "," . $next_best_coupon_id . ",'" . $device_id . "','" . date('Y-m-d') . "')";
                            $exec = $dbh->query($add_stat);
                            $stRows = $exec->rowCount();

                            $apiResponse['response_code']		= '200';
                            $apiResponse['response_data'] 	= array(
                                'promo_id' => $promo_id,
                                'coupon_id' => $next_best_coupon_id,
                                'place_id' => $place_id,
                                'is_verified' => $is_verified
                            );

                            if($is_verified == 1) {
                                $apiResponse['response_msg'] = 'Congratulations! You have been reserved the coupon successfully';
                            } else {
                                $apiResponse['response_msg'] = 'saved_from_not_verified_store';
                            }


                        } else {

                            $apiResponse['response_code'] = '200';
                            $apiResponse['response_data'] = array(
                                'promo_id' => $promo_id,
                                'coupon_id' => $next_best_coupon_id,
                                'place_id' => $place_id,
                                'is_verified' => $is_verified
                            );
                            $apiResponse['response_msg'] = 'Oops! Something went wrong. You were unable to reserve the coupon!!';

                        }

                    }
                    else {
                        $apiResponse['response_msg'] = "no_coupon_to_save";
                    }



                }

            }


        }
        else {
            $apiResponse['response_msg'] = 'coupon_not_found';
        }

    }


}

$apiResponse['response_code'] = 200;

header('Content-Type: application/json');
echo json_encode($apiResponse);