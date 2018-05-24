<?php
date_default_timezone_set('Europe/London');
include("conn.php");

$apiResponse  = array('response_code' => '','response_data' => [],'response_msg' => '');
$responseData = array('coupons' => [], 'give_away_coupon' => []);

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $device_id = $_POST['device_id'];
    $promo_id = $_POST['red_promo_id'];
    $lat = $_POST['latitude'];
    $lng = $_POST['longitude'];

    // get red friday promos
    $getRed = "SELECT `red_friday_promos`.*,`red_coupons`.*,`coupons`.* FROM `red_friday_promos` LEFT JOIN `red_coupons` ON `red_coupons`.`promo_id`=`red_friday_promos`.`promo_id` LEFT JOIN `coupons` ON `coupons`.`coupon_id`=`red_coupons`.`coupon_id` WHERE `red_friday_promos`.`promo_id`=". $promo_id;
    $redExec = $dbh->query($getRed);
    $redRows = $redExec->rowCount();
    $redPromos = $redExec->fetchAll(PDO::FETCH_OBJ);

    // get saved coupons
    $getSVD = "SELECT * FROM `user_reserved_coupons` WHERE `promo_id`=" . $promo_id . " AND `device_id`='" . $device_id . "'";
    $svdExec = $dbh->query($getSVD);
    $rowsSvd = $svdExec->rowCount();
    $savedCoups = $svdExec->fetchAll(PDO::FETCH_OBJ);

    // if user has saved a coupn
    if($rowsSvd > 0) {
        $apiResponse['response_code'] = 200;
        $apiResponse['response_data'] = '';
        $apiResponse['response_msg'] = 'You have already reserved some coupons!!';
    }
    else {
        // use has not saved any coupon
        $count = 0;
        foreach ($redPromos as $key => $promo) {

            // add location for marker
            $reLat = 0;
            $reLng = 0;

            $dist = (0.00900900900901 / 1000);

            $rand = rand(0,7);
            $val1 = rand(0,100);
            $val2 = rand(0,100);

            if($rand == 0){
                $reLat = $lat + ($dist * $val1);
                $reLng = $lng + ($dist * $val2);
            }
            else if($rand == 1) {
                $reLat = $lat - ($dist * $val1);
                $reLng = $lng + ($dist * $val2);
            }
            else if($rand == 2) {
                $reLat = $lat + ($dist * $val1);
                $reLng = $lng - ($dist * $val2);
            }
            else if($rand == 3) {
                $reLat = $lat - ($dist * $val1);
                $reLng = $lng - ($dist * $val2);
            }
            else if($rand == 4) {
                $reLat = $lat + ($dist * $val2);
                $reLng = $lng + ($dist * $val1);
            }
            else if($rand == 5) {
                $reLat = $lat - ($dist * $val2);
                $reLng = $lng + ($dist * $val1);
            }
            else if($rand == 6) {
                $reLat = $lat + ($dist * $val2);
                $reLng = $lng - ($dist * $val1);
            }
            else {
                $reLat = $lat - ($dist * $val2);
                $reLng = $lng - ($dist * $val1);
            }

            $promo->latitude = $reLat;
            $promo->longitude = $reLng;

            if($count < 50) {
                // increase count
                $count += 1;

                // coupon details
                $t_c_id = $promo->coupon_id;
                $t_available = $promo->coupon_availabilty;
                $t_occupied = $promo->count_occupied;

                // check availablity
                if($t_available > $t_occupied) {
                    // if coupons are available
                    $responseData['coupons'][] = $promo;

                    // insert record to user user_reserved_coupons table
                    $inst = "INSERT INTO `user_reserved_coupons`(`device_id`,`promo_id`,`coupon_id`) VALUES('" . $device_id . "'," . $promo_id . "," . $t_c_id . ")";
                    $instExec = $dbh->query($inst);
                    $rowInst = $instExec->rowCount();
                }
            }
        }

        $responseData['is_winner'] = 0;

        // check for pre launch winner
        $getW = "SELECT * FROM `pre_launch_winner`";
        $exec = $dbh->query($getW);
        $rows = $exec->rowCount();
        $winners = $exec->fetchAll(PDO::FETCH_OBJ);

        $win_id = $winners[0]->device_id;

        if($win_id == $device_id) {
            // get pre launch gift
            $getGift = "SELECT `promos`.*, `coupons`.* FROM `promos` LEFT JOIN `coupons` ON `coupons`.`promo_id`=`promos`.`promo_id` WHERE `promos`.`status`=3 AND `promos`.`used`='1'";
            $execGift = $dbh->query($getGift);
            $rowsGift = $execGift->rowCount();
            $giftPromo = $execGift->fetchAll(PDO::FETCH_OBJ);

            foreach ($giftPromo as $key => $gwpromo) {
                // set place id
                $place_ids = $gwpromo->place_id;
                $char_rm = ["[","]", "\""];
                $stm = trim(str_replace($char_rm,"",$place_ids));
                $stm2 = explode(',',$stm);

                $place_id = $stm2[0];

                $gwpromo->place_id = $place_id;
                $gwpromo->warning_start_time = '';
                $gwpromo->pre_launch_clue = '';
                $gwpromo->reference_image = '';

                // add location for marker
                $reLat = 0;
                $reLng = 0;

                $dist = (0.00900900900901 / 1000);

                $rand = rand(0,7);
                $val1 = rand(0,100);
                $val2 = rand(0,100);

                if($rand == 0){
                    $reLat = $lat + ($dist * $val1);
                    $reLng = $lng + ($dist * $val2);
                }
                else if($rand == 1) {
                    $reLat = $lat - ($dist * $val1);
                    $reLng = $lng + ($dist * $val2);
                }
                else if($rand == 2) {
                    $reLat = $lat + ($dist * $val1);
                    $reLng = $lng - ($dist * $val2);
                }
                else if($rand == 3) {
                    $reLat = $lat - ($dist * $val1);
                    $reLng = $lng - ($dist * $val2);
                }
                else if($rand == 4) {
                    $reLat = $lat + ($dist * $val2);
                    $reLng = $lng + ($dist * $val1);
                }
                else if($rand == 5) {
                    $reLat = $lat - ($dist * $val2);
                    $reLng = $lng + ($dist * $val1);
                }
                else if($rand == 6) {
                    $reLat = $lat + ($dist * $val2);
                    $reLng = $lng - ($dist * $val1);
                }
                else {
                    $reLat = $lat - ($dist * $val2);
                    $reLng = $lng - ($dist * $val1);
                }

                $gwpromo->latitude = $reLat;
                $gwpromo->longitude = $reLng;

                // add to user reserved table
                // coupon details
                $t_c_id = $gwpromo->coupon_id;
                $t_available = $gwpromo->coupon_availabilty;
                $t_occupied = $gwpromo->count_occupied;

                // check availablity
                if($t_available > $t_occupied) {
                    // if coupons are available
                    $responseData['give_away_coupon'][] = $gwpromo;

                    // insert record to user user_reserved_coupons table
                    $inst = "INSERT INTO `user_reserved_coupons`(`device_id`,`promo_id`,`coupon_id`) VALUES('" . $device_id . "'," . $promo_id . "," . $t_c_id . ")";
                    $instExec = $dbh->query($inst);
                    $rowInst = $instExec->rowCount();
                }


            }

            $responseData['is_winner'] = 1;
        }

        $apiResponse['response_code'] = 200;
        $apiResponse['response_data'] = $responseData;
        $apiResponse['response_msg'] = 'These are your coupons';

    }

}

header('Content-Type: application/json');
echo json_encode($apiResponse);
