<?php
date_default_timezone_set('Europe/London');
include("conn.php");

$apiResponse  = array('response_code' => '','response_data' => '','response_msg' => '');


if($_SERVER['REQUEST_METHOD'] == 'POST') {

	$promo_id = trim($_POST['promo_id']);
	$device_id = trim($_POST['device_id']);

	// get promo details
	$sql1 = "SELECT * FROM promos WHERE promo_id =".$promo_id;
	$res1 = $dbh->query($sql1);
	$promo = $res1->fetchAll(PDO::FETCH_OBJ);

	// | get advanced warning value
	$advanced_warning = $promo[0]->advance_warning;
	$time_difference = 0;
	$diff = [];

	// | get system date time and create date object
	$now = date("Y-m-d H:i:s");
	$now_time = date_create($now);

	// | if adwanced warning enabled
	if($advanced_warning == 1){

		// | get promo details
		$promo_repeate = $promo[0]->promo_repeat;
		$promo_repeate_value = trim($promo[0]->promo_repeat_values);
		$promo_start_time = trim($promo[0]->start_at);
		$promo_end_time = trim($promo[0]->end_at);

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

			$remove_chars = ["[", "]", "\""];
			$stm = trim(str_replace($remove_chars, "", $promo_repeate_value));
			$list = explode(",", $stm);


			if(in_array($day_count, $list, TRUE)){
				$temp = date("Y-m-d ". $promo_start_time);
				$promo_start = date_create($temp);
				$diff = date_diff($now_time, $promo_start);
			}

		}


		if(sizeof($diff) > 0 ) {

			if($diff->invert == 0){
				$total_in_miliseconds = ((((($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h) * 60 + $diff->i)*60 + $diff->s) * 1000);
				$time_difference = $total_in_miliseconds;

				$apiResponse['response_code'] = 200;
				$apiResponse['response_data'] = $time_difference;
				$apiResponse['response_msg'] = "time remaining";
			}
		}

	}


}


header('Content-Type: application/json');
echo json_encode($apiResponse);
