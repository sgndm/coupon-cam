<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\RetargetCoupon;
use App\RetargetSaved;
use App\RetargetStats;

use App\SavedCoupons;
use App\DeviceInfo;

use App\Classes\ExtraFunctions;
use App\Classes\Converter;
use App\Classes\PushNotification;

class SendPushReTarget implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $store_id;
    protected $store_name;
    protected $coupon_id;

    // protected $file_name;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($store_id,$store_name,$coupon_id)
    {
        $this->store_id=$store_id;
        $this->store_name=$store_name;
        $this->coupon_id=$coupon_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $push_data = [];

        // get device ids from saved coupons
        $devices = SavedCoupons::where(['place_id' => $this->store_id])
            ->select('device_id')
            ->distinct()
            ->get();

        // for all device
        foreach ($devices as $device) {

            // check for saved
            $saved_c = RetargetSaved::where(['place_id' => $this->store_id, 'device_id' => $device->device_id, 'coupon_id' => $this->coupon_id, 'status' => 4])->count();


            if($saved_c == 0) {
                // add an entry to retarget saved table
                $inst_svd = RetargetSaved::insert([
                    'place_id' => $this->store_id,
                    'coupon_id' => $this->coupon_id,
                    'device_id' => $device->device_id,
                    'status' => 4,
                    'is_push' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

                if($inst_svd) {
                    // get player id
                    $get_player_id = DeviceInfo::where(['device_id' => $device->device_id])->select('player_id')->get();

                    // player id
                    $t_player_id = $get_player_id[0]->player_id;

                    // send push
                    $notification = "Hey there you have got a coupon from " . $this->store_name;
                    $data = $push_data;
                    $devices = [$t_player_id];
                    PushNotification::create_notification($notification, $data, $devices);
                }
            }


        }

        
    }
}
