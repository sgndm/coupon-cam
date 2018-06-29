<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\SavedCoupons;
use App\Coupon;
use App\DeviceInfo;
use App\PromoStats;
use App\Promo;
use App\CouponExtend;
use App\RetargetCoupon;
use App\RetargetSaved;
use App\RetargetStats;
use App\Classes\ExtraFunctions;
use App\Classes\Converter;
use App\Classes\PushNotification;


class expireCoupons extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expire:coupons';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire saved coupons after 24 hours';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        // get saved coupons
        $saved_coupons = SavedCoupons::where(['scan_coupon_status' => 4])->orWhere(['scan_coupon_status' => 3])->get();

        // | return values
        $total_saved_count = 0;
        $success_count = 0;
        $error_count = 0;
        $failed_coupons = [];
        $updated_coupons = [];

        // get server time
        $server_location = Converter::get_server_location();
        $server_lat = $server_location['latitude'];
        $server_lng = $server_location['longitude'];

        $server_offset = Converter::get_time_zone($server_lat,$server_lng);
//        echo "server-offset : " . $server_offset . "\n\n";


        // push notification array
        $devices = [];
        $pushNotifications = [];

        // log array
        //$logArray = [];

        // get re-target saved coupons
        $get_re_saved = RetargetSaved::where(['status' => 4])->get();

        foreach ($get_re_saved as $reSaved) {
            // check date
//            echo "Retarget";
            $get_saved_date = date('Y-m-d H:i:s', strtotime($reSaved->created_at));
            $saved_date = date_create($get_saved_date);

            $get_now = date('Y-m-d H:i:s');
            $time_now = date_create($get_now);

            $get_diff = date_diff($saved_date,$time_now);

            $total_in_seconds = ((((($get_diff->y * 365.25 + $get_diff->m * 30 + $get_diff->d) * 24 + $get_diff->h) * 60 + $get_diff->i)*60 + $get_diff->s));

            if($reSaved->is_push == 1) {
                if($total_in_seconds >= 2592000) {
                    // after a month
                    // details
                    $t_store_id = $reSaved->place_id;

                    // get store details
                    // get store details by store id
                    $store_details = ExtraFunctions::get_store_details($t_store_id);

                    $country = $store_details['country'];
                    $lat = $store_details['latitude'];
                    $lng = $store_details['longitude'];

                    //get time zone
                    $get_offset = Converter::get_time_zone($lat,$lng);
//                    echo "store-offset : " . $get_offset . "\n\n";

                    $server_time = Converter::calculate_server_time($get_offset, $server_offset);
                    // echo "server-time : " . $server_time . "\n";

                    //  $server_time = date('08:24:00');
                    // time now
                    $time_now = date('H:i:s');

//                    echo "server-time : " . $server_time . " -- time now : " . $time_now . "\n";
                    if($time_now >= $server_time) {
//                        echo "\n serve time matches \n";

                        // expire coupon
                        $update_re_svd = RetargetSaved::where('coupon_id', $reSaved->coupon_id)
                            ->where('device_id', $reSaved->device_id)
                            ->update([
                                'status' => 2,
                                'updated_at' => date('Y_m-d H:i:s')
                            ]);
                    }

                }
            }
            else {
                // expire within the day
                // if($total_in_seconds >= 2592000) {
                // after a month
                // details
                $t_store_id = $reSaved->place_id;

                // get store details
                // get store details by store id
                $store_details = ExtraFunctions::get_store_details($t_store_id);

                $country = $store_details['country'];
                $lat = $store_details['latitude'];
                $lng = $store_details['longitude'];

                //get time zone
                $get_offset = Converter::get_time_zone($lat,$lng);
//                    echo "store-offset : " . $get_offset . "\n\n";

                $server_time = Converter::calculate_server_time($get_offset, $server_offset);
                // echo "server-time : " . $server_time . "\n";

//                      $server_time = date('19:31:00');
                // time now
                $time_now = date('19:32:00');
//                    $time_now = date('H:i:s');

//                    echo "server-time : " . $server_time . " -- time now : " . $time_now . "\n";
                if($time_now >= $server_time) {
//                        echo "\n serve time matches \n";

                    // expire coupon
                    $update_re_svd = RetargetSaved::where('coupon_id', $reSaved->coupon_id)
                        ->where('device_id', $reSaved->device_id)
                        ->update([
                            'status' => 3,
                            'updated_at' => date('Y_m-d H:i:s')
                        ]);
                }

                // }
            }




        }

        // end of retarget saved


        // saved
        // | for every coupon
        foreach($saved_coupons as $saved) {

            $total_saved_count += 1;

            // store id
            $store_id = $saved->place_id;
            // device id
            $device_id = $saved->device_id;
            // coupon id
            $coupon_id = $saved->scan_coupon_id;
            // coupon name
            $get_coupon_name = Coupon::where(['coupon_id' => $coupon_id])->select('coupon_title')->get()->first();
            $coupon_name = $get_coupon_name['coupon_title'];


            // coupon status
            $coupon_status = $saved->scan_coupon_status;

            // get store details by store id
            $store_details = ExtraFunctions::get_store_details($store_id);

            $country = $store_details['country'];
            $lat = $store_details['latitude'];
            $lng = $store_details['longitude'];

            //get time zone
            $get_offset = Converter::get_time_zone($lat,$lng);
            echo "store-offset : " . $get_offset . "\n\n";

            $server_time = Converter::calculate_server_time($get_offset, $server_offset);
            // echo "server-time : " . $server_time . "\n";

            // time now
            $time_now = date('H:i:s');

            echo "server-time : " . $server_time . " -- time now : " . $time_now . "\n";
            if($time_now >= $server_time) {

                //echo "server-time : " . $server_time . " -------  time-now : " . $time_now . "\n";
                if($coupon_status == 4){

                    // check if coupon has extended
                    $has_extended = $saved->has_extended;

                    if($has_extended == 1) {

                        // get expiration date
                        $get_exp_date = CouponExtend::where(['device_id' => $device_id, 'coupon_id' => $coupon_id])->get();
                        $expire_date = date('Y-m-d', strtotime($get_exp_date[0]->expire_date));

                        // today
                        $today = date('Y-m-d');


                        if($expire_date == $today) {
                            // expire coupon
                            $update = SavedCoupons::where('device_id', $device_id)->where('scan_coupon_id', $coupon_id)->update(['scan_coupon_status' => 3, 'updated_at' => date('Y-m-d H:i:s')]);

                            if($update){
                                $success_count += 1;

                                // get player id by device
                                // $get_deviceInfo = DeviceInfo::where(['device_id' => $device_id])->select('player_id')->get();
                                // $player = $get_deviceInfo[0]['player_id'];
                                // $player_ids = [$player];
                                // $notification = "Your Coupon " . $coupon_name . " has expired!";
                                // $data = array('coupon_id' => $coupon_id);
                                // send push notification
                                // PushNotification::create_notification($notification, $data, $player_ids);

                                if(in_array($device_id, $devices)) {

                                    foreach ($pushNotifications as $pushes) {
                                        $count = $pushes['count'];
                                        $pushDevice = $pushes['device_id'];

                                        if($pushDevice == $device_id) {
                                            $newCount = $count + 1;
                                            $pushes['count'] = $newCount;
                                        }

                                    }

                                } else {
                                    array_push($devices, $device_id);
                                    $temp = ['device_id' => $device_id, 'count' => 1];
                                    array_push($pushNotifications, $temp);
                                }

                                // add entry in log
                                $content = "Expired a extended coupons at " . date("Y-m-d H:i:s") . " | Total saved coupons count is " . $total_saved_count . " | Successfully updated " . $success_count . " coupons | unable to upload " . $error_count . " coupons\n";
                                ExtraFunctions::add_log_entry($content);

                            } else {
                                $error_count += 1;
                            }
                        }


                    }
                    else {
                        // expire coupon
                        $update = SavedCoupons::where('device_id', $device_id)->where('scan_coupon_id', $coupon_id)->update(['scan_coupon_status' => 3, 'updated_at' => date('Y-m-d H:i:s')]);

                        if($update){
                            $success_count += 1;

                            // get player id by device
                            // $get_deviceInfo = DeviceInfo::where(['device_id' => $device_id])->select('player_id')->get();
                            // $player = $get_deviceInfo[0]['player_id'];
                            // $player_ids = [$player];
                            // $notification = "Your Coupon " . $coupon_name . " has expired!";
                            // $data = array('coupon_id' => $coupon_id);
                            // // send push notification
                            // PushNotification::create_notification($notification, $data, $player_ids);

                            if(in_array($device_id, $devices)) {

                                foreach ($pushNotifications as $pushes) {
                                    $count = $pushes['count'];
                                    $pushDevice = $pushes['device_id'];

                                    if($pushDevice == $device_id) {
                                        $newCount = $count + 1;
                                        $pushes['count'] = $newCount;
                                    }

                                }

                            } else {
                                array_push($devices, $device_id);
                                $temp = ['device_id' => $device_id, 'count' => 1];
                                array_push($pushNotifications, $temp);
                            }

                            // add entry in log
                            $content = "Expired coupons at " . date("Y-m-d H:i:s") . " | Total saved coupons count is " . $total_saved_count . " | Successfully updated " . $success_count . " coupons | unable to upload " . $error_count . " coupons\n";
                            ExtraFunctions::add_log_entry($content);

                        } else {
                            $error_count += 1;
                        }
                    }

                } else {

                    // get coupon saved date
                    $get_saved_date = date('Y-m-d H:i:s',strtotime($saved->scan_date));
                    $saved_date = date_create($get_saved_date);

                    $get_date_now = date('Y-m-d H:i:s');
                    $date_now = date_create($get_date_now);

                    $date_diff = date_diff($date_now, $saved_date);

                    $dy = $date_diff->y;
                    $dm = $date_diff->m;
                    $dd = $date_diff->d;

                    // if coupon has been expired for two days
                    if( ($dy == 0) && ($dm == 0) && ($dd == 2) ){

                        // get coupon values
                        $get_coupon_values = Coupon::where(['coupon_id' => $saved->scan_coupon_id])->get();
                        $estimated_val = $get_coupon_values[0]['estimated_value'];

                        // convert value to different values for different countries
                        $get_values = Converter::get_values_for_countries($country, $estimated_val);

                        $val_usd = $get_values['val_usd'];
                        $val_cad = $get_values['val_cad'];
                        $val_nzd = $get_values['val_nzd'];
                        $val_aud = $get_values['val_aud'];
                        $val_uk = $get_values['val_uk'];

                        $update = SavedCoupons::where('device_id', $device_id)->where('scan_coupon_id', $coupon_id)
                            ->update([
                                'val_usd' => $val_usd,
                                'val_cad' => $val_cad,
                                'val_nzd' => $val_nzd,
                                'val_aud' => $val_aud,
                                'val_pound' => $val_uk
                            ]);

                        if($update){
                            $content = "Coupon has expired | Updated user stats at " . date("Y-m-d H:i:s") . "\n";
                            ExtraFunctions::add_log_entry($content);

                            // // get player id by device
                            // $get_deviceInfo = DeviceInfo::where(['device_id' => $device_id])->select('player_id')->get();
                            // $player = $get_deviceInfo[0]['player_id'];
                            // $player_ids = [$player];
                            // $notification = "You missed a great opportunity";
                            // $data = array('coupon_id' => $coupon_id);
                            // // send push notification
                            // PushNotification::create_notification($notification, $data, $player_ids);

                            if(in_array($device_id, $devices)) {

                                foreach ($pushNotifications as $pushes) {
                                    $count = $pushes['count'];
                                    $pushDevice = $pushes['device_id'];

                                    if($pushDevice == $device_id) {
                                        $newCount = $count + 1;
                                        $pushes['count'] = $newCount;
                                    }

                                }

                            } else {
                                array_push($devices, $device_id);
                                $temp = ['device_id' => $device_id, 'count' => 1];
                                array_push($pushNotifications, $temp);
                            }

                        }

                    }

                }


            } else {

                //continue;
                $content = "time doesn't match -- server-time : " . $server_time . " -- time-now : " . $time_now . "\n";
                ExtraFunctions::add_log_entry($content);
            }
        }

        foreach ($pushNotifications as $pushNot) {
            $push_device = $pushNot['device_id'];
            $coupon_count = $pushNot['count'];

            // get player id by device
            $get_deviceInfo = DeviceInfo::where(['device_id' => $push_device])->select('player_id')->get();
            $player = $get_deviceInfo[0]['player_id'];
            $player_ids = [$player];
            $notification = "Your Coupons has EXPIRED";
            $data = ['is_expiration' => 1,'coupon_count' => $coupon_count];
            // send push notification
            PushNotification::create_notification($notification, $data, $player_ids);
        }


        // update promo stats
        // get all active promos
        $allPromos = Promo::where(['status' => 1])->get();

        foreach ($allPromos as $promos) {

            // get stores
            $stores = $promos->place_id;
            $remChars = ["[","]","\""];
            $stm = trim(str_replace($remChars,'', $stores));
            $list = explode(',',$stm);

            // store id
            $pro_store_id = $list[0];

            // get store details by store id
            $store_details = ExtraFunctions::get_store_details($pro_store_id);

            $pro_country = $store_details['country'];
            $pro_lat = $store_details['latitude'];
            $pro_lng = $store_details['longitude'];

            //get time zone
            $get_pro_offset = Converter::get_time_zone($pro_lat,$pro_lng);
            // echo "store-offset : " . $get_offset . "\n";

            $promo_server_time = Converter::calculate_server_time($get_pro_offset, $server_offset);

            $server_time_now = date('H:i:s');

            if($server_time_now == $promo_server_time) {

                //check promo repeat values
                $promo_repeat = $promos->promo_repeat;
                $promo_repeate_values = $promos->promo_repeate_values;

                if($promo_repeat == 'Date') {
                    // if one time promo
                    // check promo date
                    $promo_date = date('Y-m-d', strtotime($promo_repeate_values));
                    $today = date('Y-m-d');

                    if($promo_date == $today) {
                        // if promo date is today
                        // expire expire promo
                        // update stats
                        $upd = Promo::where('promo_id',$promos->promo_id)->update([
                            'status' => 0,
                            'days_running' => 1,
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);

                        // add log entry
                        $content = "Expired a one time promo on " . date('Y-m-d H:i:s') . " | promo id - " . $promos->promo_id . "\n";
                        ExtraFunctions::add_log_entry($content);

                    }

                }
                else if($promo_repeat == 'Daily') {
                    // get number of days running
                    $days_running = $promos->days_running;

                    // new count
                    $new_days_count = $days_running + 1;

                    $upd = Promo::where('promo_id',$promos->promo_id)->update([
                        'days_running' => $new_days_count,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);

                    // add log entry
                    $content = "Updated promo stats on " . date('Y-m-d H:i:s') . " | promo id - " . $promos->promo_id . "\n";
                    ExtraFunctions::add_log_entry($content);
                }

                else if($promo_repeat == 'Week') {
                    // | get day (name)
                    $name = date("l");

                    if(!($name == 'Saturday') || !($name == 'Sunday') ){
                        // get number of days running
                        $days_running = $promos->days_running;

                        // new count
                        $new_days_count = $days_running + 1;

                        $upd = Promo::where('promo_id',$promos->promo_id)->update([
                            'days_running' => $new_days_count,
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);

                        // add log entry
                        $content = "Updated promo stats on " . date('Y-m-d H:i:s') . " | promo id - " . $promos->promo_id . "\n";
                        ExtraFunctions::add_log_entry($content);

                    }
                }

                else if($promo_repeat == 'Weekend'){
                    // | get day (name)
                    $name = date("l");

                    if(($name == 'Saturday') || ($name == 'Sunday') ){
                        // get number of days running
                        $days_running = $promos->days_running;

                        // new count
                        $new_days_count = $days_running + 1;

                        $upd = Promo::where('promo_id',$promos->promo_id)->update([
                            'days_running' => $new_days_count,
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);

                        // add log entry
                        $content = "Updated promo stats on " . date('Y-m-d H:i:s') . " | promo id - " . $promos->promo_id . "\n";
                        ExtraFunctions::add_log_entry($content);

                    }
                }

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
                    $stm = trim(str_replace($remove_chars, "", $promo_repeate_values));
                    $list = explode(",", $stm);


                    if(in_array($day_count, $list, TRUE)){
                        // get number of days running
                        $days_running = $promos->days_running;

                        // new count
                        $new_days_count = $days_running + 1;

                        $upd = Promo::where('promo_id',$promos->promo_id)->update([
                            'days_running' => $new_days_count,
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);

                        // add log entry
                        $content = "Updated promo stats on " . date('Y-m-d H:i:s') . " | promo id - " . $promos->promo_id . "\n";
                        ExtraFunctions::add_log_entry($content);
                    }
                }

            }

        }



    }



}
