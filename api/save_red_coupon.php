<?php
date_default_timezone_set('Europe/London');
include("conn.php");
include('func/Converter.php');

$apiResponse  = array('response_code' => '','response_data' => [],'response_msg' => '');

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    // | Get Data From Request |
    $place_id = trim($_POST["place_id"]);
    $device_id = trim($_POST["device_id"]);
    $coupon_id = trim($_POST["coupon_id"]);
    $red_promo_id = trim($_POST['red_promo_id']);

    // get store details
    $getSt = "SELECT * FROM `places` WHERE `place_id`=" . $place_id;
    $execST = $dbh->query($getSt);
    $rowSt = $execST->rowCount();
    $stores = $execST->fetchAll(PDO::FETCH_OBJ);

    $country = $stores[0]->country_short;

    // get promo id
    $getPID = "SELECT * FROM `coupons` WHERE `coupon_id`=" . $coupon_id;
    $execPID = $dbh->query($getPID);
    $PIDs = $execPID->fetchAll(PDO::FETCH_OBJ);

    // promo id
    $promo_id = $PIDs[0]->promo_id;

    // get promo details
    $getPromo = "SELECT * FROM `promos` WHERE `promo_id`=". $promo_id;
    $exec_getPromo  = $dbh->query($getPromo);
    $promo_det = $exec_getPromo->fetchAll(PDO::FETCH_OBJ);

    // status
    $status = $promo_det[0]->status;

    // get coupon details
    $getCP = "SELECT * FROM `coupons` WHERE `coupon_id`=" . $coupon_id;
    $execCP  =$dbh->query($getCP);
    $rowCP = $execCP->rowCount();
    $coupons = $execCP->fetchAll(PDO::FETCH_OBJ);

    $coupon = $coupons[0];

    $val_coup = $coupon->estimated_value;

    // convert value
    $val_USD = 0;
    $val_CAD = 0;
    $val_NZD = 0;
    $val_AUD = 0;
    $val_UK = 0;

    $get_values = Converter::get_values_for_countries($country, $val_coup);

    $val_USD = $get_values['val_usd'];
    $val_NZD = $get_values['val_nzd'];
    $val_AUD = $get_values['val_aud'];
    $val_CAD = $get_values['val_cad'];
    $val_UK = $get_values['val_uk'];



    // check if user is the winner
    $get_winner = "SELECT * FROM `pre_launch_winner`";
    $exec_get_winner = $dbh->query($get_winner);
    $winners = $exec_get_winner->fetchAll(PDO::FETCH_OBJ);

    // winner
    $winn_id = $winners[0]->device_id;

    // check if user has saved any coupon for this red friday promo

    $checkSVD = "SELECT * FROM `user_coupons` WHERE `device_id`='" . $device_id ."' AND `red_promo_id`=" . $red_promo_id . " AND `is_red_friday` = 1";
    $exec_chksvd = $dbh->query($checkSVD);
    $totalSaved = $exec_chksvd->rowCount();

    if($totalSaved > 0) {
        $apiResponse['response_code'] = 200;
        $apiResponse['response_data'] = array('is_saved' => 0, 'is_winner' => 1);
        $apiResponse['response_msg'] = "already_saved_a_coupon";
    }
    else {


        // check user
        if ($winn_id == $device_id) {
            // if user is the winner
            // check is this a give away coupon
            if ($status == 3) {
                // if a give away promo
                // save coupon
                // check availability
                if ($coupon->coupon_availabilty > $coupon->count_occupied) {
                    // if coupons are available
                    // check if user has saved this coupon before
                    $chk_saved = "SELECT * FROM `user_coupons` WHERE `device_id`='" . $device_id . "' AND `scan_coupon_id`=" . $coupon_id;
                    $exec_chk = $dbh->query($chk_saved);
                    $saved_rows = $exec_chk->rowCount();

                    if ($saved_rows > 0) {
                        // if user has saved this coupon before
                        $apiResponse['response_code'] = 200;
                        $apiResponse['response_data'] = array('is_saved' => 0);
                        $apiResponse['response_msg'] = "You have already saved this coupon";
                    } else {
                        // if user hasn't saved this coupon before
                        // insert into saved
                        $insert = "INSERT INTO `user_coupons`(`scan_promo_id`,`scan_coupon_id`,`device_id`,`scan_coupon_status`,`scan_date`,`val_usd`,`val_cad`,`val_nzd`,`val_aud`,`val_pound`, `is_red_friday`,`red_promo_id`,`place_id`) VALUES(" . $promo_id . "," . $coupon_id . ",'" . $device_id . "',4,'" . date('Y-m-d') . "', " . $val_USD . "," . $val_CAD . "," . $val_NZD . "," . $val_AUD . ", " . $val_UK . ",1," . $red_promo_id . "," . $place_id . ")";

                        $execute_q = $dbh->query($insert);
                        $rowsInsert = $execute_q->rowCount();

                        if ($rowsInsert > 0) {
                            $new_ocupied_count = ($coupon->count_occupied) + 1;

                            $sql5 = "UPDATE `coupons` SET `count_occupied`='" . $new_ocupied_count . "' WHERE `coupon_id` = '" . $coupon_id . "'";
                            $res5 = $dbh->query($sql5);
                            $rows5 = $res5->rowCount();

                            $add_stat = "INSERT INTO `promo_stats`(`place_id`,`promo_id`,`device_id`,`created_at`) VALUES(" . $place_id . "," . $promo_id . ",'" . $device_id . "','" . date('Y-m-d') . "')";
                            $exec = $dbh->query($add_stat);
                            $stRows = $exec->rowCount();

                            // update user reserved
                            $updUR = "UPDATE `user_reserved_coupons` SET `status`=1 WHERE `coupon_id`=" . $coupon_id . " AND `device_id`='" . $device_id . "'";
                            $execUPD = $dbh->query($updUR);


                            $apiResponse['response_code'] = 200;
                            $apiResponse['response_data'] = array('is_saved' => 1, 'is_winner' => 1);
                            $apiResponse['response_msg'] = "successfully saved a give away coupon";

                        } else {
                            $apiResponse['response_code'] = 200;
                            $apiResponse['response_data'] = array('is_saved' => 0, 'is_winner' => 1);
                            $apiResponse['response_msg'] = "Unable to save coupons";
                        }
                    }

                } else {
                    // if coupon is not available
                    $apiResponse['response_code'] = 200;
                    $apiResponse['response_data'] = array('is_saved' => 0, 'is_winner' => 1);
                    $apiResponse['response_msg'] = "Coupon is not available";
                }
            } else {
                // if this is not a give away coupon
                $apiResponse['response_code'] = 200;
                $apiResponse['response_data'] = array('is_saved' => 0, 'is_winner' => 1);
                $apiResponse['response_msg'] = "give_away_price_available";
            }

        } else {
            // if user is not the winner
            // save the coupon
            // check availability
            if ($coupon->coupon_availabilty > $coupon->count_occupied) {
                // if coupons are available
                // check if user has saved this coupon before
                $chk_saved = "SELECT * FROM `user_coupons` WHERE `device_id`='" . $device_id . "' AND `scan_coupon_id`=" . $coupon_id;
                $exec_chk = $dbh->query($chk_saved);
                $saved_rows = $exec_chk->rowCount();

                if ($saved_rows > 0) {
                    // if user has saved this coupon before
                    $apiResponse['response_code'] = 200;
                    $apiResponse['response_data'] = array('is_saved' => 0, 'is_winner' => 0);
                    $apiResponse['response_msg'] = "You have already saved this coupon";
                } else {
                    // if user hasn't saved this coupon before
                    // insert into saved
                    $insert = "INSERT INTO `user_coupons`(`scan_promo_id`,`scan_coupon_id`,`device_id`,`scan_coupon_status`,`scan_date`,`val_usd`,`val_cad`,`val_nzd`,`val_aud`,`val_pound`, `is_red_friday`,`red_promo_id`,`place_id`) VALUES(" . $promo_id . "," . $coupon_id . ",'" . $device_id . "',4,'" . date('Y-m-d') . "', " . $val_USD . "," . $val_CAD . "," . $val_NZD . "," . $val_AUD . ", " . $val_UK . ",1," . $red_promo_id . "," . $place_id . ")";

                    $execute_q = $dbh->query($insert);
                    $rowsInsert = $execute_q->rowCount();

                    if ($rowsInsert > 0) {
                        $new_ocupied_count = ($coupon->count_occupied) + 1;

                        $sql5 = "UPDATE `coupons` SET `count_occupied`='" . $new_ocupied_count . "' WHERE `coupon_id` = '" . $coupon_id . "'";
                        $res5 = $dbh->query($sql5);
                        $rows5 = $res5->rowCount();

                        $add_stat = "INSERT INTO `promo_stats`(`place_id`,`promo_id`,`device_id`,`created_at`) VALUES(" . $place_id . "," . $promo_id . ",'" . $device_id . "','" . date('Y-m-d') . "')";
                        $exec = $dbh->query($add_stat);
                        $stRows = $exec->rowCount();

                        // update user reserved
                        $updUR = "UPDATE `user_reserved_coupons` SET `status`=1 WHERE `coupon_id`=" . $coupon_id . " AND `device_id`='" . $device_id . "'";
                        $execUPD = $dbh->query($updUR);


                        $apiResponse['response_code'] = 200;
                        $apiResponse['response_data'] = array('is_saved' => 1, 'is_winner' => 0);
                        $apiResponse['response_msg'] = "successfully saved a coupon";

                    } else {
                        $apiResponse['response_code'] = 200;
                        $apiResponse['response_data'] = array('is_saved' => 0, 'is_winner' => 0);
                        $apiResponse['response_msg'] = "Unable to save coupons";
                    }
                }

            } else {
                // if coupon is not available
                $apiResponse['response_code'] = 200;
                $apiResponse['response_data'] = array('is_saved' => 0, 'is_winner' => 0);
                $apiResponse['response_msg'] = "Coupon is not available";
            }
        }

    }




}

header('Content-Type: application/json');
echo json_encode($apiResponse);
