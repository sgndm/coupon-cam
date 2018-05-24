<?php
include('conn.php');
$apiResponse  = array('response_code' => '','response_data' => '','response_msg' => '');


if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $device_id = trim($_POST['device_id']);
    $store_id = trim($_POST['store_id']);
    $status = trim($_POST['status']);

    // | check user has verify store before | //
    $sql1 = "SELECT * FROM `store_verifications` WHERE `device_id` = '" . $device_id . "' AND `store_id`='" . $store_id . "'";
    $res1 = $dbh->query($sql1);
    $rows1 = $res1->rowCount();
    $result = $res1->fetchAll(PDO::FETCH_OBJ);

    if($rows1 > 0) {

        $is_verified = $result[0]->status;

        if($is_verified == 1) {
            $apiResponse['response_code']		= '200';
            $apiResponse['response_data'] 	= array('device_id' => $device_id, 'store_id' => $store_id, 'is_verified' => 1, 'is_reported' => 0);
            $apiResponse['response_msg'] 		= 'You have already verified this store';
        } else {
            $apiResponse['response_code']		= '200';
            $apiResponse['response_data'] 	= array('device_id' => $device_id, 'store_id' => $store_id, 'is_verified' => 0, 'is_reported' => 1);
            $apiResponse['response_msg'] 		= 'You have already reported this store';
        }


    }
    else {

        // | Check status | //
        if($status == 1) {

            // | verify store | //
            $sql2 = "INSERT INTO `store_verifications`(`device_id`, `store_id`, `status`, `verified_date`) VALUES ('" . $device_id . "'," . $store_id . "," . $status . ",'" . date('Y-m-d H:i:s') . "')";
            $res2 = $dbh->query($sql2);
            $rows2 = $res2->rowCount();

            // | get verified count from store | //
            $sql4 = "SELECT * FROM `places` WHERE `place_id`=". $store_id;
            $res4 = $dbh->query($sql4);
            $rows4 = $res4->rowCount();
            $result4 = $res4->fetchAll(PDO::FETCH_OBJ);

            $verified_count = $result4[0]->verified_count;

            if($verified_count < 2){
                $new_verifeied_count  = $verified_count + 1;
                // update store details //
                $sql5 = "UPDATE `places` SET `verified_count`=". $new_verifeied_count . " WHERE `place_id`=". $store_id;
                $res5 = $dbh->query($sql5);
                $rows5 = $res5->rowCount();

            } else if ($verified_count == 2) {
                // update store as verified //
                $new_verifeied_count  = $verified_count + 1;
                // update store details //
                $sql5 = "UPDATE `places` SET `verified_count`=". $new_verifeied_count . ",`is_verified`=1 WHERE `place_id`=". $store_id;
                $res5 = $dbh->query($sql5);
                $rows5 = $res5->rowCount();
            } else {
				// update store as verified //
                $new_verifeied_count  = $verified_count + 1;
                // update store details //
                $sql5 = "UPDATE `places` SET `verified_count`=". $new_verifeied_count . ",`is_verified`=1 WHERE `place_id`=". $store_id;
                $res5 = $dbh->query($sql5);
                $rows5 = $res5->rowCount();
			}

            if(($rows2 > 0) && ($rows5 > 0)){
                $apiResponse['response_code']		= '200';
                $apiResponse['response_data'] 	= array('device_id' => $device_id, 'store_id' => $store_id, 'is_verified' => 1, 'is_reported' => 0);
                $apiResponse['response_msg'] 		= 'Successfully verified this store';
            } else {
                $apiResponse['response_code']		= '200';
                $apiResponse['response_data'] 	= array('device_id' => $device_id, 'store_id' => $store_id, 'is_verified' => 0, 'is_reported' => 0);
                $apiResponse['response_msg'] 		= 'unable to verify this store';
            }

        } else {
            // | report store | //
			$sql3 = "INSERT INTO `store_verifications`(`device_id`, `store_id`, `status`, `verified_date`) VALUES ('" . $device_id . "'," . $store_id . "," . $status . ",'" . date('Y-m-d H:i:s') . "')";
			$res3 = $dbh->query($sql3);
			$rows3 = $res3->rowCount();

            // | get verified count from store | //
            $sql4 = "SELECT * FROM `places` WHERE `place_id`=". $store_id;
            $res4 = $dbh->query($sql4);
            $rows4 = $res4->rowCount();
            $result4 = $res4->fetchAll(PDO::FETCH_OBJ);

            $verified_count = $result4[0]->verified_count;

            $new_verifeied_count  = $verified_count - 1;
            // update store details //
            $sql5 = "UPDATE `places` SET `verified_count`=". $new_verifeied_count . " WHERE `place_id`=". $store_id;
            $res5 = $dbh->query($sql5);
            $rows5 = $res5->rowCount();

			if(($rows3 > 0) && ($rows5 > 0)){
				$apiResponse['response_code']		= '200';
				$apiResponse['response_data'] 	= array('device_id' => $device_id, 'store_id' => $store_id, 'is_verified' => 0, 'is_reported' => 1);
				$apiResponse['response_msg'] 		= 'Successfully reported this store';
			} else {
				$apiResponse['response_code']		= '200';
				$apiResponse['response_data'] 	= array('device_id' => $device_id, 'store_id' => $store_id, 'is_verified' => 0, 'is_reported' => 0);
				$apiResponse['response_msg'] 		= 'unable to report this store';
			}
        }

        

    }



}

header('Content-Type: application/json');
echo json_encode($apiResponse);

