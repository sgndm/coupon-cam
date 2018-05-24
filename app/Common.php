<?php

namespace App;
use App\Notifications;
use App\User;
use App\Store;
use App\Promo;
use App\Coupon;
use Illuminate\Database\Eloquent\Model;

class Common extends Model
{
    public static function GetTotalNotify($userid) {
        $count = Notifications::where(['user_id' => $userid,'active' => '1'])->count();
        return $count;
    }
    
    public static function UserInfo($userid) {
        return User::find($userid);
    }
    
    public static function itemInfo($cat,$id) {
        if($cat === 'shop'){
        $x = Store::find($id);
        }elseif($cat === 'coupon'){
        $x = Coupon::find($id);
        }elseif($cat === 'promo'){
        $x = Promo::find($id);
        }
        return $x;
    }
}
