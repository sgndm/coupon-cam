<?php
include("conn.php");
include("func/Converter.php");

$apiResponse  = array('response_code' => '','response_data' => array(),'response_msg' => '');

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $device_id = trim($_POST['device_id']);
    $coupon_id = trim($_POST['coupon_id']);
    $min_spend = trim($_POST['min_spend']);

    if(empty($device_id)) {
        $apiResponse['response_code'] = 200;
        $apiResponse['response_data'] = array();
        $apiResponse['response_msg'] = "device_id_is_empty!";
        
    } else if(empty($coupon_id)) {

        $apiResponse['response_code'] = 200;
        $apiResponse['response_data'] = array();
        $apiResponse['response_msg'] = "coupon_id_empty!";

    } else if(empty($min_spend)){

        $apiResponse['response_code'] = 200;
        $apiResponse['response_data'] = array();
        $apiResponse['response_msg'] = "min_spend_is_empty!";

    } else {
        // get saved coupons
        $sql = "SELECT * FROM `user_coupons` WHERE `device_id`='" . $device_id . "' AND `scan_coupon_id`='" . $coupon_id . "'";
        $res = $dbh->query($sql);
        $rows = $res->rowCount();
        $saved_coupons = $res->fetchAll(PDO::FETCH_OBJ);

        // get store id
        $store_id = $saved_coupons[0]->place_id;

        // get country of store
        $getStsql = "SELECT * FROM `places` WHERE `place_id`=" . $store_id;
        $excGetSt = $dbh->query($getStsql);
        $stDetails = $excGetSt->fetchAll(PDO::FETCH_OBJ);

        // country
        $st_country = $stDetails[0]->country_short;


        $min_spend_us = 0;
        $min_spend_ca = 0;
        $min_spend_nz = 0;
        $min_spend_au = 0;
        $min_spend_uk = 0;

        // convert values
        if ($st_country == "GB") {

            $base_C = 'GBP';

            $min_spend_us = Converter::currencyConverter($base_C, 'USD', $min_spend);
            $min_spend_ca = Converter::currencyConverter($base_C, 'CAD', $min_spend);
            $min_spend_nz = Converter::currencyConverter($base_C, 'NZD', $min_spend);
            $min_spend_au = Converter::currencyConverter($base_C, 'AUD', $min_spend);
            $min_spend_uk = $min_spend;

        } elseif ($st_country == "NZ") {

            $base_C = 'NZD';

            $min_spend_us = Converter::currencyConverter($base_C, 'USD', $min_spend);
            $min_spend_ca = Converter::currencyConverter($base_C, 'CAD', $min_spend);
            $min_spend_nz = $min_spend;
            $min_spend_au = Converter::currencyConverter($base_C, 'AUD', $min_spend);
            $min_spend_uk = Converter::currencyConverter($base_C, 'GBP', $min_spend);

        } elseif ($st_country == "CA") {

            $base_C = 'CAD';

            $min_spend_us = Converter::currencyConverter($base_C, 'USD', $min_spend);
            $min_spend_ca = $min_spend;
            $min_spend_nz = Converter::currencyConverter($base_C, 'NZD', $min_spend);
            $min_spend_au = Converter::currencyConverter($base_C, 'AUD', $min_spend);
            $min_spend_uk = Converter::currencyConverter($base_C, 'GBP', $min_spend);

        } elseif ($st_country == "AU") {

            $base_C = 'AUD';

            $min_spend_us = Converter::currencyConverter($base_C, 'USD', $min_spend);
            $min_spend_ca = Converter::currencyConverter($base_C, 'CAD', $min_spend);
            $min_spend_nz = Converter::currencyConverter($base_C, 'NZD', $min_spend);
            $min_spend_au = $min_spend;
            $min_spend_uk = Converter::currencyConverter($base_C, 'GBP', $min_spend);

        } else {

            $base_C = 'USD';

            $min_spend_us = $min_spend;
            $min_spend_ca = Converter::currencyConverter($base_C, 'CAD', $min_spend);
            $min_spend_nz = Converter::currencyConverter($base_C, 'NZD', $min_spend);
            $min_spend_au = Converter::currencyConverter($base_C, 'AUD', $min_spend);
            $min_spend_uk = Converter::currencyConverter($base_C, 'GBP', $min_spend);

        }

        $cur_min_spend_us = $saved_coupons[0]->min_spend_us;
        $cur_min_spend_ca = $saved_coupons[0]->min_spend_ca;
        $cur_min_spend_nz = $saved_coupons[0]->min_spend_nz;
        $cur_min_spend_au = $saved_coupons[0]->min_spend_au;
        $cur_min_spend_uk = $saved_coupons[0]->min_spend_uk;

        // new values 
        $new_min_spend_us = ($cur_min_spend_us + $min_spend_us);
        $new_min_spend_ca = ($cur_min_spend_ca + $min_spend_ca);
        $new_min_spend_nz = ($cur_min_spend_nz + $min_spend_nz);
        $new_min_spend_au = ($cur_min_spend_au + $min_spend_au);
        $new_min_spend_uk = ($cur_min_spend_uk + $min_spend_uk);


        $sql3 = "UPDATE `user_coupons` SET `min_spend_us` = " . $new_min_spend_us . ", `min_spend_uk` = " . $new_min_spend_uk . ", `min_spend_us` = " . $new_min_spend_us . ", `min_spend_au` = " . $new_min_spend_au . ", `min_spend_nz` = " . $new_min_spend_nz . ", `min_spend_ca` = " . $new_min_spend_ca . " WHERE `device_id`='" . $device_id . "' AND `scan_coupon_id`='" . $coupon_id . "'";

        $res3 = $dbh->query($sql3);
        $rows3 = $res3->rowCount();

        if($rows3 > 0) {
            $apiResponse['response_code'] = 200;
            $apiResponse['response_data'] = array('coupon_id' => $coupon_id, 'device_id' => $device_id, 'min_spend' => $min_spend);
            $apiResponse['response_msg'] = "min_spend_added_successfully!";
        } 
        else {
            $apiResponse['response_code'] = 200;
            $apiResponse['response_data'] = array('coupon_id' => $coupon_id, 'device_id' => $device_id, 'min_spend' => $min_spend);
            $apiResponse['response_msg'] = "min_spend_added_faild!";
        }
    }

    
}

    
header('Content-Type: application/json');
echo json_encode($apiResponse);