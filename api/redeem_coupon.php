<?php

include("conn.php");
include("func/Converter.php");

$apiResponse  = array('response_code' => '','response_data' => array(),'response_msg' => '');

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $device_id = trim($_POST['device_id']);
    $coupon_id = trim($_POST['coupon_id']);
    $qr_code = trim($_POST['qr_code']);
    $is_prelaunched = trim($_POST['is_prelaunched']);

    if((empty($device_id)) && (empty($coupon_id)) && (empty($qr_code)) ){

        $apiResponse['response_code'] = 200;
        $apiResponse['response_data'] = array('place_id' => $place_id, 'device_id' => $device_id);
        $apiResponse['response_msg'] = "some data is missing please check";
    }
    else{

        // | Check user coupons | //
        $sql = "SELECT * FROM `user_coupons` WHERE `device_id`='" . $device_id . "' AND `scan_coupon_id`='" . $coupon_id . "'";
        $res = $dbh->query($sql);
        $rows = $res->rowCount();
        $saved_coupons = $res->fetchall(PDO::FETCH_OBJ);

        // get coupon status
        $saved_status = $saved_coupons[0]->scan_coupon_status;

        if ($saved_status == 4) {
            $is_saved = 1;
        } else {
            $is_saved = 0;
        }


        // get store id
        $store_id = $saved_coupons[0]->place_id;

        // check user
        $checkFirst = "SELECT * FROM `user_coupons` WHERE `device_id`='". $device_id ."' AND `place_id`=". $store_id;
        $executeChekc = $dbh->query($checkFirst);
        $rowCountCheck = $executeChekc->rowCount();

        $is_first_time = 0;

        if($rowCountCheck == 1) {
            $is_first_time = 1;
        }


        // get country of store
        $getStsql = "SELECT * FROM `places` WHERE `place_id`=" . $store_id;
        $excGetSt = $dbh->query($getStsql);
        $stDetails = $excGetSt->fetchall(PDO::FETCH_OBJ);

        // country
        $st_country = $stDetails[0]->country_short;

        if ($rows > 0) {

            // | If coupon available | //
            // | Get Coupon Details
            $sql2 = "SELECT * FROM `coupons` WHERE `coupon_id`='" . $coupon_id . "'";
            $res2 = $dbh->query($sql2);
            $rows2 = $res2->rowCount();
            $coupon_details = $res2->fetchall(PDO::FETCH_OBJ);

            // get coupon value
            $value = $coupon_details[0]->estimated_value;

            // coupon value for different countries
            $val_USD = 0;
            $val_CAD = 0;
            $val_NZD = 0;
            $val_AUD = 0;
            $val_UK = 0;

            // convert values
            if ($st_country == "GB") {

                $base_C = 'GBP';

                $val_USD = Converter::currencyConverter($base_C, 'USD', $value);
                $val_CAD = Converter::currencyConverter($base_C, 'CAD', $value);
                $val_NZD = Converter::currencyConverter($base_C, 'NZD', $value);
                $val_AUD = Converter::currencyConverter($base_C, 'AUD', $value);
                $val_UK = $value;

            } elseif ($st_country == "NZ") {

                $base_C = 'NZD';

                $val_USD = Converter::currencyConverter($base_C, 'USD', $value);
                $val_CAD = Converter::currencyConverter($base_C, 'CAD', $value);
                $val_NZD = $value;
                $val_AUD = Converter::currencyConverter($base_C, 'AUD', $value);
                $val_UK = Converter::currencyConverter($base_C, 'GBP', $value);

            } elseif ($st_country == "CA") {

                $base_C = 'CAD';

                $val_USD = Converter::currencyConverter($base_C, 'USD', $value);
                $val_CAD = $value;
                $val_NZD = Converter::currencyConverter($base_C, 'NZD', $value);
                $val_AUD = Converter::currencyConverter($base_C, 'AUD', $value);
                $val_UK = Converter::currencyConverter($base_C, 'GBP', $value);

            } elseif ($st_country == "AU") {

                $base_C = 'AUD';

                $val_USD = Converter::currencyConverter($base_C, 'USD', $value);
                $val_CAD = Converter::currencyConverter($base_C, 'CAD', $value);
                $val_NZD = Converter::currencyConverter($base_C, 'NZD', $value);
                $val_AUD = $value;
                $val_UK = Converter::currencyConverter($base_C, 'GBP', $value);

            } else {

                $base_C = 'USD';

                $val_USD = $value;
                $val_CAD = Converter::currencyConverter($base_C, 'CAD', $value);
                $val_NZD = Converter::currencyConverter($base_C, 'NZD', $value);
                $val_AUD = Converter::currencyConverter($base_C, 'AUD', $value);
                $val_UK = Converter::currencyConverter($base_C, 'GBP', $value);

            }

            // | Get Promo id
            $promo_id = $coupon_details[0]->promo_id;

            // | Check for loyalty coupon | //
            $is_loyalty = $coupon_details[0]->is_loyalty;
            $count_occupied = $coupon_details[0]->count_occupied;
            $new_count_occupied = 0;

            $used_count = $saved_coupons[0]->used_times;
            $new_used_count = 0;

            $total_used_counts = $saved_coupons[0]->total_used_times;
            $new_total_used_times = 0;

            // | get Qr code
            $getQr = "SELECT `qr_code` FROM `places` WHERE `place_id`='" . $store_id . "'";
            $excGetQR = $dbh->query($getQr);
            $qrDetails = $excGetQR->fetchall(PDO::FETCH_OBJ);

            $qr_code_promo = $qrDetails[0]->qr_code;

            // get level four coupon
            $getLvl4 = "SELECT * FROM `coupons` WHERE `promo_id`=". $promo_id . " AND `coupon_level`=4";
            $execLvl4 = $dbh->query($getLvl4);
            $lvl4Rows = $execLvl4->rowCount();
            $level4Coupon = $execLvl4->fetchAll(PDO::FETCH_OBJ);

            // get details
            $level4CouponId = $level4Coupon[0]->coupon_id;
            $valLevel4 = $level4Coupon[0]->estimated_value;
            $lvl4CountOccupied = $level4Coupon[0]->count_occupied;

            $newCount = ($lvl4CountOccupied + 1);


            $get_values_l4 = Converter::get_values_for_countries($st_country, $valLevel4);

            $val_USD_l4 = $get_values_l4['val_usd'];
            $val_NZD_l4 = $get_values_l4['val_nzd'];
            $val_AUD_l4 = $get_values_l4['val_aud'];
            $val_CAD_l4 = $get_values_l4['val_cad'];
            $val_UK_l4 = $get_values_l4['val_uk'];

            $add_bonus = "INSERT INTO `user_coupons`(`scan_promo_id`,`scan_coupon_id`,`device_id`,`scan_coupon_status`,`scan_date`,`val_usd`,`val_cad`,`val_nzd`,`val_aud`,`val_pound`,`place_id`) VALUES(" . $promo_id ."," . $level4CouponId . ",'" . $device_id . "',4,'" . date('Y-m-d') . "', " . $val_USD_l4 . "," . $val_CAD_l4 . "," . $val_NZD_l4 . "," . $val_AUD_l4 . ", " . $val_UK_l4 . "," . $store_id . ")";

            $update_coupon = "UPDATE `coupons` SET `count_occupied`='" . $newCount . "' WHERE `coupon_id` = " . $level4CouponId;




            // | check qr codes
            if ($qr_code == $qr_code_promo) {
                // if qr code matches

                if ($is_loyalty == 1) {
                    // | if is loyalty coupon | //
                    $loyalty_count = $coupon_details[0]->loyalty_count;

                    // calculate new valuse for different countries
                    // | get current values
                    $cur_val_usd = $saved_coupons[0]->val_usd;
                    $cur_val_cad = $saved_coupons[0]->val_cad;
                    $cur_val_nzd = $saved_coupons[0]->val_nzd;
                    $cur_val_aud = $saved_coupons[0]->val_aud;
                    $cur_val_uk = $saved_coupons[0]->val_pound;

                    $new_val_usd = ($cur_val_usd + $val_USD);
                    $new_val_cad = ($cur_val_cad + $val_CAD);
                    $new_val_nzd = ($cur_val_nzd + $val_NZD);
                    $new_val_aud = ($cur_val_aud + $val_AUD);
                    $new_val_uk = ($cur_val_uk + $val_UK);


                    // | check used coupon count | //
                    if ($used_count == 0) {
                        $is_bonus = $saved_coupons[0]->is_bonus;

                        if ($is_bonus == 1) {
                            $new_total_used_times = $total_used_counts + 1;
                            // | update user coupon table | //
                            $sql3 = "UPDATE `user_coupons` SET `scan_coupon_status`=2,`redeem_date`='" . date("Y-m-d H:i:s") . "',`is_bonus`=0,`total_used_times`=" . $new_total_used_times . ",`val_usd` = " . $new_val_usd . ", `val_cad` = " . $new_val_cad . ", `val_aud` = " . $new_val_aud . ", `val_nzd` = " . $new_val_nzd . ", `val_pound` = " . $new_val_uk . " WHERE `device_id`='" . $device_id . "' AND `scan_coupon_id`='" . $coupon_id . "'";

                            $res3 = $dbh->query($sql3);
                            $rows3 = $res3->rowCount();

                            if ($rows3 > 0) {
                                // | update count coupon occupied | //
                                $new_count_occupied = $count_occupied + 1;
                                $sql4 = "UPDATE `coupons` SET `count_occupied`=" . $new_count_occupied . " WHERE `coupon_id`='" . $coupon_id . "'";

                                if($is_first_time == 1) {
                                    $addBonus = $dbh->query($add_bonus);
                                    $bonusRows = $addBonus->rowCount();

                                    if($bonusRows > 0) {
                                        $updateCoupon = $dbh->query($update_coupon);
                                    }
                                }

                                $res4 = $dbh->query($sql4);
                                $rows4 = $res4->rowCount();

                                if ($rows4 > 0) {

                                    // add record for stats
                                    $add_stat = "INSERT INTO `promo_stats`(`place_id`,`promo_id`,`coupon_id`,`device_id`,`created_at`) VALUES(" . $store_id . "," . $promo_id . "," . $coupon_id . ",'" . $device_id . "','" . date('Y-m-d') . "')";
                                    $exec = $dbh->query($add_stat);
                                    $stRows = $exec->rowCount();

                                    $apiResponse['response_code'] = 200;
                                    $apiResponse['response_data'] = array('coupon_id' => $coupon_id, 'device_id' => $device_id, 'is_loyalty' => 1, 'loyalty_count' => $loyalty_count, 'used_count' => $new_used_count);
                                    $apiResponse['response_msg'] = "Coupon redeemed successfully!";
                                } else {
                                    $apiResponse['response_code'] = 200;
                                    $apiResponse['response_data'] = array('coupon_id' => $coupon_id, 'device_id' => $device_id, 'is_loyalty' => 1, 'loyalty_count' => $loyalty_count, 'used_count' => $used_count);
                                    $apiResponse['response_msg'] = "Redeem coupon failed!";
                                }


                            }
                            else {

                                $apiResponse['response_code'] = 200;
                                $apiResponse['response_data'] = array('coupon_id' => $coupon_id, 'device_id' => $device_id, 'is_loyalty' => 1, 'loyalty_count' => $loyalty_count, 'used_count' => $used_count);
                                $apiResponse['response_msg'] = "Redeem coupon failed!";

                            }
                        }
                        else {
                            $new_used_count = $used_count + 1;
                            $new_total_used_times = $total_used_counts + 1;
                            // | update user coupon table | //
                            $sql3 = "UPDATE `user_coupons` SET `scan_coupon_status`=2,`redeem_date`='" . date("Y-m-d H:i:s") . "',`used_times`='" . $new_used_count . "',`total_used_times`=" . $new_total_used_times . ",`val_usd` = " . $new_val_usd . ", `val_cad` = " . $new_val_cad . ", `val_aud` = " . $new_val_aud . ", `val_nzd` = " . $new_val_nzd . ", `val_pound` = " . $new_val_uk . " WHERE `device_id`='" . $device_id . "' AND `scan_coupon_id`='" . $coupon_id . "'";

                            $res3 = $dbh->query($sql3);
                            $rows3 = $res3->rowCount();

                            if ($rows3 > 0) {

                                // | update count coupon occupied | //
                                $new_count_occupied = $count_occupied + 1;
                                $sql4 = "UPDATE `coupons` SET `count_occupied`=" . $new_count_occupied . " WHERE `coupon_id`='" . $coupon_id . "'";

                                if($is_first_time == 1) {
                                    $addBonus = $dbh->query($add_bonus);
                                    $bonusRows = $addBonus->rowCount();

                                    if($bonusRows > 0) {
                                        $updateCoupon = $dbh->query($update_coupon);
                                    }
                                }

                                $res4 = $dbh->query($sql4);
                                $rows4 = $res4->rowCount();

                                if ($rows4 > 0) {

                                    if ($is_saved == 0) {
                                        // add record for stats
                                        $add_stat = "INSERT INTO `promo_stats`(`place_id`,`promo_id`,`coupon_id`,`device_id`,`created_at`) VALUES(" . $store_id . "," . $promo_id . "," . $coupon_id . ",'" . $device_id . "','" . date('Y-m-d') . "')";
                                        $exec = $dbh->query($add_stat);
                                        $stRows = $exec->rowCount();
                                    }


                                    $apiResponse['response_code'] = 200;
                                    $apiResponse['response_data'] = array('coupon_id' => $coupon_id, 'device_id' => $device_id, 'is_loyalty' => 1, 'loyalty_count' => $loyalty_count, 'used_count' => $new_used_count);
                                    $apiResponse['response_msg'] = "Coupon redeemed successfully!";
                                } else {
                                    $apiResponse['response_code'] = 200;
                                    $apiResponse['response_data'] = array('coupon_id' => $coupon_id, 'device_id' => $device_id, 'is_loyalty' => 1, 'loyalty_count' => $loyalty_count, 'used_count' => $used_count);
                                    $apiResponse['response_msg'] = "Redeem coupon failed!";
                                }


                            } else {

                                $apiResponse['response_code'] = 200;
                                $apiResponse['response_data'] = array('coupon_id' => $coupon_id, 'device_id' => $device_id, 'is_loyalty' => 1, 'loyalty_count' => $loyalty_count, 'used_count' => $used_count);
                                $apiResponse['response_msg'] = "Redeem coupon failed!";

                            }
                        }
                    }
                    else if ($used_count < ($loyalty_count - 1)) {
                        $new_used_count = $used_count + 1;
                        $new_total_used_times = $total_used_counts + 1;
                        // | update user coupon table | //
                        $sql3 = "UPDATE `user_coupons` SET `scan_coupon_status`=2,`redeem_date`='" . date("Y-m-d H:i:s") . "',`used_times`='" . $new_used_count . "',`total_used_times`=" . $new_total_used_times . ",`val_usd` = " . $new_val_usd . ", `val_cad` = " . $new_val_cad . ", `val_aud` = " . $new_val_aud . ", `val_nzd` = " . $new_val_nzd . ", `val_pound` = " . $new_val_uk . " WHERE `device_id`='" . $device_id . "' AND `scan_coupon_id`='" . $coupon_id . "'";

                        $res3 = $dbh->query($sql3);
                        $rows3 = $res3->rowCount();

                        if ($rows3 > 0) {

                            // | update count coupon occupied | //
                            $new_count_occupied = $count_occupied + 1;
                            $sql4 = "UPDATE `coupons` SET `count_occupied`=" . $new_count_occupied . " WHERE `coupon_id`='" . $coupon_id . "'";

                            if($is_first_time == 1) {
                                $addBonus = $dbh->query($add_bonus);
                                $bonusRows = $addBonus->rowCount();

                                if($bonusRows > 0) {
                                    $updateCoupon = $dbh->query($update_coupon);
                                }
                            }

                            $res4 = $dbh->query($sql4);
                            $rows4 = $res4->rowCount();

                            if ($rows4 > 0) {

                                if ($is_saved == 0) {
                                    // add record for stats
                                    $add_stat = "INSERT INTO `promo_stats`(`place_id`,`promo_id`,`coupon_id`,`device_id`,`created_at`) VALUES(" . $store_id . "," . $promo_id . "," . $coupon_id . ",'" . $device_id . "','" . date('Y-m-d') . "')";
                                    $exec = $dbh->query($add_stat);
                                    $stRows = $exec->rowCount();
                                }


                                $apiResponse['response_code'] = 200;
                                $apiResponse['response_data'] = array('coupon_id' => $coupon_id, 'device_id' => $device_id, 'is_loyalty' => 1, 'loyalty_count' => $loyalty_count, 'used_count' => $new_used_count);
                                $apiResponse['response_msg'] = "Coupon redeemed successfully!";
                            } else {
                                $apiResponse['response_code'] = 200;
                                $apiResponse['response_data'] = array('coupon_id' => $coupon_id, 'device_id' => $device_id, 'is_loyalty' => 1, 'loyalty_count' => $loyalty_count, 'used_count' => $used_count);
                                $apiResponse['response_msg'] = "Redeem coupon failed!";
                            }


                        } else {

                            $apiResponse['response_code'] = 200;
                            $apiResponse['response_data'] = array('coupon_id' => $coupon_id, 'device_id' => $device_id, 'is_loyalty' => 1, 'loyalty_count' => $loyalty_count, 'used_count' => $used_count);
                            $apiResponse['response_msg'] = "Redeem coupon failed!";

                        }

                    }
                    else if ($used_count == ($loyalty_count - 1)) {
                        // | if loyalty count == used count | //
                        // | reset used count | //
                        $new_used_count = 0;
                        $new_total_used_times = $total_used_counts + 1;
                        // | update user coupon table | //
                        $sql5 = "UPDATE `user_coupons` SET `scan_coupon_status`=2,`redeem_date`='" . date("Y-m-d H:i:s") . "',`used_times`='" . $new_used_count . "',`is_bonus`=1,`total_used_times`=" . $new_total_used_times . ",`val_usd` = " . $new_val_usd . ", `val_cad` = " . $new_val_cad . ", `val_aud` = " . $new_val_aud . ", `val_nzd` = " . $new_val_nzd . ", `val_pound` = " . $new_val_uk . " WHERE `device_id`='" . $device_id . "' AND `scan_coupon_id`='" . $coupon_id . "'";

                        $res5 = $dbh->query($sql5);
                        $rows5 = $res5->rowCount();

                        if ($rows5 > 0) {

                            // | update count coupon occupied | //
                            $new_count_occupied = $count_occupied + 1;
                            $sql4 = "UPDATE `coupons` SET `count_occupied`=" . $new_count_occupied . " WHERE `coupon_id`='" . $coupon_id . "'";

                            if($is_first_time == 1) {
                                $addBonus = $dbh->query($add_bonus);
                                $bonusRows = $addBonus->rowCount();

                                if($bonusRows > 0) {
                                    $updateCoupon = $dbh->query($update_coupon);
                                }
                            }

                            $res4 = $dbh->query($sql4);
                            $rows4 = $res4->rowCount();

                            if ($rows4 > 0) {

                                if ($is_saved == 0) {
                                    // add record for stats
                                    $add_stat = "INSERT INTO `promo_stats`(`place_id`,`promo_id`,`coupon_id`,`device_id`,`created_at`) VALUES(" . $store_id . "," . $promo_id . "," . $coupon_id . ",'" . $device_id . "','" . date('Y-m-d') . "')";
                                    $exec = $dbh->query($add_stat);
                                    $stRows = $exec->rowCount();
                                }


                                $apiResponse['response_code'] = 200;
                                $apiResponse['response_data'] = array('coupon_id' => $coupon_id, 'device_id' => $device_id, 'is_loyalty' => 1, 'loyalty_count' => $loyalty_count, 'used_count' => ($used_count + 1));
                                $apiResponse['response_msg'] = "Coupon redeemed successfully!";
                            } else {
                                $apiResponse['response_code'] = 200;
                                $apiResponse['response_data'] = array('coupon_id' => $coupon_id, 'device_id' => $device_id, 'is_loyalty' => 1, 'loyalty_count' => $loyalty_count, 'used_count' => $used_count);
                                $apiResponse['response_msg'] = "Redeem coupon failed!";
                            }


                        } else {

                            $apiResponse['response_code'] = 200;
                            $apiResponse['response_data'] = array('coupon_id' => $coupon_id, 'device_id' => $device_id, 'is_loyalty' => 1, 'loyalty_count' => $loyalty_count, 'used_count' => $used_count);
                            $apiResponse['response_msg'] = "Redeem coupon failed!";

                        }
                    }

                }
                else {
                    $coupon_status = $saved_coupons[0]->scan_coupon_status;

                    if ($coupon_status == 4) {
                        //$new_used_count = $used_count + 1;
                        $new_total_used_times = $total_used_counts + 1;
                        // | update user coupon table | //
                        $sql3 = "UPDATE `user_coupons` SET `scan_coupon_status`=2,`redeem_date`='" . date("Y-m-d H:i:s") . "',`total_used_times`=" . $new_total_used_times . ",`val_usd` = " . $val_USD . ", `val_cad` = " . $val_CAD . ", `val_aud` = " . $val_AUD . ", `val_nzd` = " . $val_NZD . ", `val_pound` = " . $val_UK . " WHERE `device_id`='" . $device_id . "' AND `scan_coupon_id`='" . $coupon_id . "'";

                        $res3 = $dbh->query($sql3);
                        $rows3 = $res3->rowCount();

                        if ($rows3 > 0) {

                            if($is_first_time == 1) {
                                $addBonus = $dbh->query($add_bonus);
                                $bonusRows = $addBonus->rowCount();

                                if($bonusRows > 0) {
                                    $updateCoupon = $dbh->query($update_coupon);
                                }
                            }

                            $apiResponse['response_code'] = 200;
                            $apiResponse['response_data'] = array('coupon_id' => $coupon_id, 'device_id' => $device_id, 'is_loyalty' => 0, 'loyalty_count' => 0, 'used_count' => 0);
                            $apiResponse['response_msg'] = "Coupon redeemed successfully!";
                        } else {
                            $apiResponse['response_code'] = 200;
                            $apiResponse['response_data'] = array('coupon_id' => $coupon_id, 'device_id' => $device_id, 'is_loyalty' => 0, 'loyalty_count' => 0, 'used_count' => 0);
                            $apiResponse['response_msg'] = "Redeem coupon failed!";
                        }
                    }
                    else {
                        $apiResponse['response_code'] = 200;
                        $apiResponse['response_data'] = array('coupon_id' => $coupon_id, 'device_id' => $device_id, 'is_loyalty' => 0, 'loyalty_count' => 0, 'used_count' => 0);
                        $apiResponse['response_msg'] = "Redeem coupon failed!";
                    }

                }


            } else {
                // | If coupon not available | //
                $apiResponse['response_code'] = 200;
                $apiResponse['response_data'] = array('qr_code' => $qr_code);
                $apiResponse['response_msg'] = "Invalid qr code";
            }

        }
        else {
            // | If coupon not available | //
            $apiResponse['response_code'] = 200;
            $apiResponse['response_data'] = array('coupon_id' => $coupon_id, 'device_id' => $device_id, 'is_loyalty' => 0, 'loyalty_count' => 0, 'used_count' => 0);
            $apiResponse['response_msg'] = "Invalid coupon id or device id";
        }


        $apiResponse['response_data']['is_first_time'] = $is_first_time;


    }



}

header('Content-Type: application/json');
echo json_encode($apiResponse);
