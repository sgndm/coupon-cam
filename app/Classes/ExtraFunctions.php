<?php
namespace App\Classes;

use App\Store;
use App\SavedCoupons;
use App\DeviceInfo;
use App\Promo;
use App\RedPromo;
use App\Coupon;
use App\PromoLocations;
use App\PreLaunch;
use App\Winner;
use App\AppSettings;
use App\UserReserved;

class ExtraFunctions {

    public static function get_store_details($store_id){
        $get_store = Store::where(['place_id' => $store_id])->get();

        $store_country = $get_store[0]->country_short;
        $store_lat = $get_store[0]->latitude;
        $store_lng = $get_store[0]->longitude;

        $return = [
            'country' => $store_country,
            'latitude' => $store_lat,
            'longitude' => $store_lng
        ];

        return($return);
    }

    public static function add_log_entry($content) {

        $logFile = fopen("log_files/expire_coupon_log.txt", "a") or die("Unable to open file!");
        fwrite($logFile, $content);
		    fclose($logFile);

    }

    public static function get_new_customers($promo_id) {
        $get_saved_coups = SavedCoupons::where(['scan_promo_id' => $promo_id, 'scan_date' => date('y-m-d')])
            ->distinct()
            ->get('device_id');

        foreach ($get_saved_coups as $coup) {
            // get device id
            $device_id = $coup->device_id;


        }
    }

    // select users
    public static function select_user($users,$lat,$lng,$red_promo_id){

  		$id_pool = [];

      // for all user
  		foreach ($users as $user) {
        // get user lat long
  			$t_lat = $user->lat;
  			$t_lng = $user->lng;

  			// calculate distance
  			$dist = (((acos(sin(($lat*pi()/180)) * sin(($t_lat*pi()/180)) + cos(($lat*pi()/180)) * cos(($t_lat*pi()/180)) * cos((($lng - $t_lng)*pi()/180)))) * 180/pi())*60*1.1515*1.609344);

        // time
        $get_time = date('Y-m-d H:i:s');
        $time_now = date_create($get_time);

        // get last updated time
  			$get_lastUP = date('Y-m-d H:i:s', strtotime($user->last_open_date));
  			$lastUP = date_create($get_lastUP);
  			$diff2 = date_diff($lastUP,$time_now);

        if($diff2->invert == 0){
          // remaining time in seconds
  				$rem_time2 = ((((($diff2->y * 365.25 + $diff2->m * 30 + $diff2->d) * 24 + $diff2->h) * 60 + $diff2->i)*60 + $diff2->s));
          if($rem_time2 <= 360 ) {
            // if location has updated within 6mins
  					if($dist <= 0.9) {
              // echo "\n dist  : " . $dist . "\n";
              // check for red friday savings
              $red_friday_savings = UserReserved::where(['promo_id' => $red_promo_id, 'device_id' => $user->device_id, 'status' => 1])->count();

              if($red_friday_savings == 0) {
                // get pre launch saved for this user
                $get_saved = PreLaunch::where(['device_id' => $user->device_id])->get();
                // for every saving
                foreach ($get_saved as $saved) {
                  // add to array
    							array_push($id_pool,$user->device_id);
    						}
              }

            }
          }
        }


      }

      return ($id_pool);

    }

    public static function add_winner_to_table($winner){
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

      // update setting table
      $upd = AppSettings::where('setting_name','is_award_given')->update(['setting' => 1, 'updated_at' => date('Y-m-d H:i:s')]);
      $upd = AppSettings::where('setting_name','due_time')->update(['setting' => 1, 'updated_at' => date('Y-m-d H:i:s')]);


    }

    public static function get_users_by_store($store_id) {
        // return
        $return = [];

        // get device ids from saved coupons
        $devices = SavedCoupons::where(['place_id' => $store_id])
            ->select('device_id')
            ->distinct()
            ->get();
        
        if(sizeof($devices) > 0) {
            // for each device
            foreach ($devices as $device) {
                // get player id
                $get_player = DeviceInfo::where(['device_id' => $device->device_id ])->select('player_id')->get();

                // player id
                $player_id = $get_player[0]->player_id;

                array_push($return, $player_id);
            }
        }

        // return
        return $return;
    }

}
