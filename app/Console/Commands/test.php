<?php

// get give away promo
$gWPromo = Promo::where(['status' => 3, 'used' => '1'])->get();
$promo_id = $gWPromo[0]->promo_id;

// get coupon id
$get_coup = Coupon::where(['promo_id' => $promo_id])->get();
$coupon_id = $get_coup[0]->coupon_id;

// get promo_location
$promo_loc = PromoLocations::where(['promo_id' => $promo_id])->get();
$lat = $promo_loc[0]->lat_code;
$lng = $promo_loc[0]->lng_code;

// get app version
$get_app_v = AppSettings::where(['setting_name' => 'app_version'])->get();
// app version
$app_version = $get_app_v[0]['setting'];

// get users | who has updated the app to new version
$users = DeviceInfo::where(['app_version' => $app_version])->get();

// check remaining time for main Launch
$get_main_launch = AppSettings::where(['setting_name' => 'is_main_ready'])->get();

$get_main_start = date("Y-m-d H:i:s", strtotime($get_main_launch[0]['date']));
$get_now = date('Y-m-d H:i:s');
// $get_now = date('2018-05-16 17:28:47');

echo "time now: " . $get_now . "\n";
echo "main start: ". $get_main_start. "\n";

$main_start = date_create($get_main_start);
$now_time = date_create($get_now);

$diff = date_diff($now_time, $main_start);


if($diff->invert == 0){
	// remaining time in seconds
	$rem_time = ((((($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h) * 60 + $diff->i)*60 + $diff->s));

	// check remaining time
	if( ($rem_time <= 60) && ($rem_time > 0) ) {
		// if remaining time is 1 min

		$return = [];
		$device_ids = [];

		$id_pool = [];

		// for all user
		foreach ($users as $user) {

			// get user lat long
			$t_lat = $user->lat;
			$t_lng = $user->lng;

			// calculate distance
			$dist = (((acos(sin(($lat*pi()/180)) * sin(($t_lat*pi()/180))
			+ cos(($lat*pi()/180)) * cos(($t_lat*pi()/180))
			* cos((($lng - $t_lng)*pi()/180))))
			* 180/pi())*60*1.1515*1.609344);

			// get last updated time
			$get_lastUP = date('Y-m-d H:i:s', strtotime($user->last_open_date));
			$lastUP = date_create($get_lastUP);
			$diff2 = date_diff($lastUP,$now_time);

			// print_r($diff2);
			if($diff2->invert == 0){
				// remaining time in seconds
				$rem_time2 = ((((($diff2->y * 365.25 + $diff2->m * 30 + $diff2->d) * 24 + $diff2->h) * 60 + $diff2->i)*60 + $diff2->s));

				if($rem_time2 <= 360 ) {
					// if location has updated within 6mins
					if($dist <= 0.9) {

						array_push($device_ids,$user->device_id);

						$get_saved = PreLaunch::where(['device_id' => $user->device_id])->get();

						foreach ($get_saved as $saved) {
							array_push($id_pool,$user->device_id);
						}

				 }
				}else {
					// echo "location hasn't update within 6 mins\n";
				}
			}

		}


		if(sizeof($id_pool) > 0) {
			// print_r($id_pool);
			// shuffle array
			shuffle($id_pool);
			$index = array_rand($id_pool,1);
			$winner = $id_pool[$index];

			// get records from ore launch table
			$count_win_table = Winner::count();
			// echo "record count" . $count_win_table . "\n";

			if($count_win_table == 0) {
				// insert winner into pre launch winner table
				$add_win = Winner::insert(['device_id' => $winner, 'updated_at' => date('Y-m-d H:i:s')]);
			}
			else {
				// update table
				$get_id = Winner::select('id')->get()->first();
				$rec_id = $get_id['id'];

				$up = winner::where('id', $rec_id)->update(['device_id' => $winner, 'updated_at' => date('Y-m-d H:i:s')]);
			}

			echo "\nwinner" . $winner . "\n";
		}
		else {
			echo "No users has been selected \n";
		}


	}

}
else {
	// invert == 1
	// remaining time in seconds
	$rem_time = ((((($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h) * 60 + $diff->i)*60 + $diff->s));

	if( ($rem_time <= 90) && ($rem_time > 30)){
		// after 90 seconds check if users has saved the give away coupon
		// get winner
		$get_winner = Winner::get();

		// winner
		$winner = $get_winner[0]['device_id'];
		$check_saved = SavedCoupons::where(['device_id' => $winner, 'scan_coupon_id' => $coupon_id])->count();

		if($check_saved == 0) {
			// if user hasn't saved the coupon
			// send a push
			// send push
			$get_deviceInfo = DeviceInfo::where(['device_id' => $winner])->select('player_id')->get();
			$player = $get_deviceInfo[0]['player_id'];
			$player_ids = [$player];
			$notification = "You have been selected to win the Maserati. Find to save";
			$data = [];
			// send push notification
			PushNotification::create_notification($notification, $data, $player_ids);

		}
	}
	else if(($rem_time <= 150) && ($rem_time > 90)) {
		$return = [];
		$device_ids = [];

		$id_pool = [];

		// for all user
		foreach ($users as $user) {

			// get user lat long
			$t_lat = $user->lat;
			$t_lng = $user->lng;

			// calculate distance
			$dist = (((acos(sin(($lat*pi()/180)) * sin(($t_lat*pi()/180))
			+ cos(($lat*pi()/180)) * cos(($t_lat*pi()/180))
			* cos((($lng - $t_lng)*pi()/180))))
			* 180/pi())*60*1.1515*1.609344);

			// get last updated time
			$get_lastUP = date('Y-m-d H:i:s', strtotime($user->last_open_date));
			$lastUP = date_create($get_lastUP);
			$diff2 = date_diff($lastUP,$now_time);

			// print_r($diff2);
			if($diff2->invert == 0){
				// remaining time in seconds
				$rem_time2 = ((((($diff2->y * 365.25 + $diff2->m * 30 + $diff2->d) * 24 + $diff2->h) * 60 + $diff2->i)*60 + $diff2->s));

				if($rem_time2 <= 360 ) {
					// if location has updated within 6mins
					if($dist <= 0.9) {

						array_push($device_ids,$user->device_id);

						$get_saved = PreLaunch::where(['device_id' => $user->device_id])->get();

						foreach ($get_saved as $saved) {
							array_push($id_pool,$user->device_id);
						}

				 }
				}else {
					// echo "location hasn't update within 6 mins\n";
				}
			}

		}


		if(sizeof($id_pool) > 0) {
			// print_r($id_pool);
			// shuffle array
			shuffle($id_pool);
			$index = array_rand($id_pool,1);
			$winner = $id_pool[$index];

			// get records from ore launch table
			$count_win_table = Winner::count();
			// echo "record count" . $count_win_table . "\n";

			if($count_win_table == 0) {
				// insert winner into pre launch winner table
				$add_win = Winner::insert(['device_id' => $winner, 'updated_at' => date('Y-m-d H:i:s')]);
			}
			else {
				// update table
				$get_id = Winner::select('id')->get()->first();
				$rec_id = $get_id['id'];

				$up = winner::where('id', $rec_id)->update(['device_id' => $winner, 'updated_at' => date('Y-m-d H:i:s')]);
			}

			echo "\nwinner updated" . $winner . "\n";
		}
		else {
			echo "No users has been selected \n";
		}
	}
	else if(($rem_time <= 210) && ($rem_time > 150)) {
		// after 90 seconds check if users has saved the give away coupon
		// get winner
		$get_winner = Winner::get();

		// winner
		$winner = $get_winner[0]['device_id'];
		$check_saved = SavedCoupons::where(['device_id' => $winner, 'scan_coupon_id' => $coupon_id])->count();

		if($check_saved == 0) {
			// if user hasn't saved the coupon
			// send a push
			// send push
			$get_deviceInfo = DeviceInfo::where(['device_id' => $winner])->select('player_id')->get();
			$player = $get_deviceInfo[0]['player_id'];
			$player_ids = [$player];
			$notification = "You have been selected to win the Maserati. Find to save";
			$data = [];
			// send push notification
			PushNotification::create_notification($notification, $data, $player_ids);

		}

	}

}

 ?>
