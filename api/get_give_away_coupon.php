<?php
include("conn.php");

$apiResponse  = array('response_code' => '','response_data' => [],'response_msg' => '');
$responseData = array('give_away_coupon' => []);

if($_SERVER['REQUEST_METHOD'] == 'POST') {


  $device_id = $_POST['device_id'];
  $promo_id = $_POST['red_promo_id'];
  $lat = $_POST['latitude'];
  $lng = $_POST['longitude'];

  // check if user is in the area
  // get red promo location
  $get_p_l = "SELECT * FROM `red_friday_promos` WHERE `promo_id`=" . $promo_id;
  $exec_get_p_l = $dbh->query($get_p_l);
  $r_p_det = $exec_get_p_l->fetchAll(PDO::FETCH_OBJ);

  // get lat long
  $latitude = $r_p_det[0]->latitude;
  $longitude = $r_p_det[0]->longitude;

  // calculate distance
  $dist = (((acos(sin(($lat*pi()/180)) * sin(($latitude*pi()/180))+ cos(($lat*pi()/180)) * cos(($latitude*pi()/180)) * cos((($lng - $longitude)*pi()/180)))) * 180/pi())*60*1.1515*1.609344);

  $responseData['dist'] = $dist;

  if ($dist <= 0.1) {
    // if user is within 100m
    // check if user is the winner
    $get_winner = "SELECT * FROM `pre_launch_winner`";
    $exec_getWinner = $dbh->query($get_winner);
    $winners = $exec_getWinner->fetchAll(PDO::FETCH_OBJ);

    // winner
    $win_id = $winners[0]->device_id;

    if($win_id == $device_id) {
      // if user is the winner
      // get give away coupons
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
        $val1 = rand(0,300);
        $val2 = rand(0,300);

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

        $responseData['give_away_coupon'][] = $gwpromo;
      }

      $apiResponse['response_code'] = 200;
      $apiResponse['response_data'] = $responseData;
      $apiResponse['response_msg'] = "Give away coupons";
    }
    else {
      $apiResponse['response_code'] = 200;
      $apiResponse['response_data'] = $responseData;
      $apiResponse['response_msg'] = "Oh you have miss the give away price";
    }

  }
  else {
    $apiResponse['response_code'] = 200;
    $apiResponse['response_data'] = $responseData;
    $apiResponse['response_msg'] = "Hey come closer...";
  }

}

header('Content-Type: application/json');
echo json_encode($apiResponse);
