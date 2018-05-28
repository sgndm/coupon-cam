<?php

namespace App\Console\Commands;

use App\DeviceInfo;
use App\Promo;
use App\RedPromo;
use App\Coupon;
use App\PromoLocations;
use App\PreLaunch;
use App\Winner;
use App\SavedCoupons;
use App\AppSettings;
use App\Classes\ExtraFunctions;
use App\Classes\Converter;
use App\Classes\PushNotification;



use Illuminate\Console\Command;

class selectWinner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'select:winner';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        // get give away red friday promo
        $get_rp = RedPromo::where(['is_pre_launch' => 1, 'used' => 1, 'status' => 1])->get();
        $red_promo_id = $get_rp[0]->promo_id;

        // get promo_location
        // $promo_loc = PromoLocations::where(['promo_id' => $promo_id])->get();
        $lat = $get_rp[0]->latitude;
        $lng = $get_rp[0]->longitude;

        // red promo start time
        $rp_start = date('Y-m-d H:i:s', strtotime($get_rp[0]->st_date_server . " " . $get_rp[0]->start_at));
        $rp_length = $get_rp[0]->length;

        // calculate end time
        $rp_end = date('Y-m-d H:i:s', strtotime("+$rp_length min", strtotime($rp_start)));

        echo "\n rp start :" . $rp_start . "\n";
        echo "\n rp end : " . $rp_end . "\n";

        // get give away promo
        $gWPromo = Promo::where(['status' => 3, 'used' => '1'])->get();
        $promo_id = $gWPromo[0]->promo_id;

        // get coupon id
        $get_coup = Coupon::where(['promo_id' => $promo_id])->get();
        $coupon_id = $get_coup[0]->coupon_id;

        // get app version
        $get_app_v = AppSettings::where(['setting_name' => 'app_version'])->get();
        // app version
        $app_version = $get_app_v[0]['setting'];

        // get app version
        $get_award_given = AppSettings::where(['setting_name' => 'is_award_given'])->get();
        // app version
        $is_award_given = $get_award_given[0]['setting'];

        // get app version
        $get_due_time = AppSettings::where(['setting_name' => 'due_time'])->get();
        // app version
        $due_time = $get_due_time[0]['setting'];

        // get users | who has updated the app to new version
        $users = DeviceInfo::get();
        // print_r($users);
        // time now
        $get_now = date("Y-m-d H:i:s");
        echo "\n time now  : " . $get_now . "\n";

        // create date objects
        $time_now = date_create($get_now);
        $time_start = date_create($rp_start);
        $time_end = date_create($rp_end);

        if( $get_now < $rp_end ) {
            // echo "\n promo hasn't end yet\n";
            // if promo is ongoing
            // check start time
            $diff_st = date_diff($time_now, $time_start);

            echo "\n diff invert : " . $diff_st->invert . " \n";
            // check difference
            if($diff_st->invert == 0) {
                // remaining time in seconds
                $rem_time = ((((($diff_st->y * 365.25 + $diff_st->m * 30 + $diff_st->d) * 24 + $diff_st->h) * 60 + $diff_st->i)*60 + $diff_st->s));

                // check remaining time
                if( ($rem_time <= 60) && ($rem_time > 0) ) {
                    echo "\n 1 min to end the timer\n";
                    // if remaining time is 1 min
                    // select users
                    $id_pool = ExtraFunctions::select_user($users,$lat,$lng,$red_promo_id);

                    // select a random user
                    if(sizeof($id_pool) > 0) {
                        // shuffle array
                        shuffle($id_pool);
                        // get random index
                        $index = array_rand($id_pool,1);
                        // select element from array
                        $winner = $id_pool[$index];

                        echo "\n THE WINNER IS : " . $winner . "\n";

                        // insert or update table
                        $ins = ExtraFunctions::add_winner_to_table($winner);

                        $content = "Selected a winner at : " . $get_now . " | winner is : " . $winner . "\n";
                        ExtraFunctions::WinnerLog($content);

                    }
                    else {
                        echo "\n No ids to select \n";
                    }



                }

            }
            else {
                // echo "\n invert == 1 \n";
                // if promo has begun
                if($is_award_given == 1) {
                    // echo "\n is_award_given == 1 \n";
                    // if a user has been selected
                    if($due_time == 1){
                        // echo "\n due_time == 1 \n";
                        // if due time == 1
                        // check if user has saved the give away coupon
                        // get winner
                        $get_winner = Winner::get();
                        $winner = $get_winner[0]->device_id;
                        // check saved
                        $check_saved = SavedCoupons::where(['device_id' => $winner, 'scan_coupon_id' => $coupon_id])->count();

                        if($check_saved == 0) {
                            echo "\n Sending a push... \n";
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

                            $upd = AppSettings::where('setting_name','due_time')->update(['setting' => 2, 'updated_at' => date('Y-m-d H:i:s')]);

                            $content = "Send a push notification at : " . $get_now . " | to winner : " . $winner . "\n";
                            ExtraFunctions::WinnerLog($content);


                        }

                    }
                    else if ($due_time == 2) {
                        // if due time == 2
                        // select winner again
                        echo "\n selecting winner again... \n";
                        // if remaining time is 1 min
                        // select users
                        $id_pool = ExtraFunctions::select_user($users,$lat,$lng,$red_promo_id);

                        // select a random user
                        if(sizeof($id_pool) > 0) {
                            // shuffle array
                            shuffle($id_pool);
                            // get random index
                            $index = array_rand($id_pool,1);
                            // select element from array
                            $winner = $id_pool[$index];

                            echo "\n THE NEW WINNER IS : " . $winner . "\n";

                            // insert or update table
                            $ins = ExtraFunctions::add_winner_to_table($winner);

                            $content = "Selected a new winner  at : " . $get_now . " | to winner : " . $winner . "\n";
                            ExtraFunctions::WinnerLog($content);

                        }


                    }
                }
            }
        }
        else {
            // check due time
            if($due_time == 0) {

            }
            else {
                // update app settings
                // set due time to 0
                // set is main ready to 0
                $upd = AppSettings::where('setting_name','due_time')->update(['setting' => 0, 'updated_at' => date('Y-m-d H:i:s')]);
                $upd2 = AppSettings::where('setting_name','is_main_ready')->update(['setting' => 0, 'updated_at' => date('Y-m-d H:i:s')]);

                // update give away promo
                // set status to 0
                // set red friday status to 0
                $upd3 = Promo::where('promo_id', $promo_id)->update(['status' => 0, 'updated_at' => date('Y-m-d H:i:s')]);
                $upd3 = RedPromo::where('promo_id', $red_promo_id)->update(['status' => 0, 'updated_at' => date('Y-m-d H:i:s')]);

                $content = "Red friday promo has stopped at : " . date('Y-m-d H:i:s') . "\n";
                ExtraFunctions::WinnerLog($content);

            }
        }


    }
}
