<?php

include("conn.php");
include("func/Converter.php");

$apiResponse  = array('response_code' => '','response_data' => array(),'response_msg' => '');

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $device_id = trim($_POST['device_id']);
    $coupon_id = trim($_POST['coupon_id']);
    $place_id = trim($_POST['place_id']);
    $qr_code = trim($_POST['qr_code']);

    if(empty($device_id)) {
        $apiResponse['response_code'] = 200;
        $apiResponse['response_msg'] = 'device_id_is_empty';
        $apiResponse['response_data'] = [];
    }
    else if(empty($coupon_id)) {
        $apiResponse['response_code'] = 200;
        $apiResponse['response_msg'] = 'coupon_id_is_empty';
        $apiResponse['response_data'] = [];
    }
    else if(empty($place_id)) {
        $apiResponse['response_code'] = 200;
        $apiResponse['response_msg'] = 'place_id_is_empty';
        $apiResponse['response_data'] = [];
    }
    else if(empty($qr_code)) {
        $apiResponse['response_code'] = 200;
        $apiResponse['response_msg'] = 'qr_code_is_empty';
        $apiResponse['response_data'] = [];
    }
    else {

        // check if coupon is available
        $chkSvd = "SELECT * FROM `retarget_saved` WHERE `device_id`='" . $device_id . "' AND `coupon_id`=" . $coupon_id . " AND `place_id`=" . $place_id;
        $execSvd = $dbh->query($chkSvd);
        $rowsSvd = $execSvd->rowCount();
        $svdCoup = $execSvd->fetchAll(PDO::FETCH_OBJ);

        if($rowsSvd > 0) {
            $c_status = $svdCoup[0]->status;
            if($c_status == 4) {
                // check qr code
                $getQr = "SELECT * FROM `places` WHERE `place_id`=" . $place_id;
                $execQr = $dbh->query($getQr);
                $rowsQr = $execQr->rowCount();
                $getQRCode = $execQr->fetchAll(PDO::FETCH_OBJ);

                if($rowsQr > 0) {
                    $t_qr_code = $getQRCode[0]->qr_code;

                    if($qr_code == $t_qr_code) {

                        // redeem coupon
                        $updSvd = "UPDATE `retarget_saved` SET `status`=2  WHERE `device_id`='" . $device_id . "' AND `coupon_id`=" . $coupon_id . " AND `place_id`=" . $place_id;
                        $execUpd = $dbh->query($updSvd);
                        $rowsUpd = $execUpd->rowCount();

                        if($rowsUpd > 0) {
                            $apiResponse['response_code'] = 200;
                            $apiResponse['response_msg'] = 'coupon_redeemed_success';
                            $apiResponse['response_data'] = [];
                        }
                        else {
                            $apiResponse['response_code'] = 200;
                            $apiResponse['response_msg'] = 'unable_to_redeem_coupon';
                            $apiResponse['response_data'] = [];
                        }

                    } else {
                        $apiResponse['response_code'] = 200;
                        $apiResponse['response_msg'] = 'qr_code_mismatch';
                        $apiResponse['response_data'] = [];
                    }
                }
                else {
                    $apiResponse['response_code'] = 200;
                    $apiResponse['response_msg'] = 'unable_to_find_the_store';
                    $apiResponse['response_data'] = [];
                }
            }
            else if( $c_status == 2) {
                $apiResponse['response_code'] = 200;
                $apiResponse['response_msg'] = 'already_redeemed';
                $apiResponse['response_data'] = [];
            } else {
                $apiResponse['response_code'] = 200;
                $apiResponse['response_msg'] = 'not_available';
                $apiResponse['response_data'] = [];
            }



        }
        else {
            $apiResponse['response_code'] = 200;
            $apiResponse['response_msg'] = 'unable_to_find_coupon';
            $apiResponse['response_data'] = [];
        }

    }

}


header('Content-Type: application/json');
echo json_encode($apiResponse);