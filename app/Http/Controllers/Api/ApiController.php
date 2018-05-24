<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Media;
use App\Store;
use App\StoreCategory;
use App\Promo;
use App\Coupon;
use Image;
use Auth;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function allstores($userid)
    {
        $stores = Store::join('users','users.id','=','stores.user_id')
                        ->where(['stores.active' => '1','users.active' => '1',"stores.user_id" => $userid])
                        ->select('stores.*','users.name as company')
                        ->get();
        return json_encode($stores);
    }
	
	public function store($userid,$storeid)
    {
        $stores = Store::join('users','users.id','=','stores.user_id')
                        ->where(['stores.active' => '1','users.active' => '1',"stores.user_id" => $userid,"stores.id" => $storeid])
                        ->select('stores.*','users.name as company')
                        ->first();
        return json_encode($stores);
    }
    
    
    public function allpromo($userid)
    {
        $promos = Promo::join('users','users.id','=','promos.user_id')
						->join('stores','promos.user_id','=','stores.user_id')
										->where(['promos.active' => '1','users.active' => '1',"promos.user_id" => $userid])
										->select('promos.*','stores.name as company')
										->get();
        return json_encode($promos);
    }
	
	public function allpromo_store($userid,$storeid)
    {
        $promos = Promo::join('users','users.id','=','promos.user_id')
						->join('stores','promos.user_id','=','stores.user_id')
										->where(['promos.active' => '1','users.active' => '1',"promos.user_id" => $userid])
										->select('promos.*','stores.name as company')
										->get();
		$promo_list = [];
		
		foreach($promos as $key => $promo){
			if(is_array(json_decode($promo->store_id))){
				$pram = json_decode($promo->store_id);
				for($n = 0; $n < count($pram); $n++){
					if($pram[$n] == $storeid){
						$promo_list[] = $promo;
					}
				}
			}else{
				if($promo->store_id == $storeid){
					$promo_list[] = $promo;
				}
			}
			
		}
		
		return json_encode($promo_list);
        
    }
	
	public function promo($userid,$promoid)
    {
        $promos = Promo::join('users','users.id','=','promos.user_id')
						->join('stores','promos.store_id','=','stores.id')
										->where(['promos.active' => '1','users.active' => '1',"promos.user_id" => $userid,"promos.id" => $promoid])
										->select('promos.*','stores.name as company')
										->first();
        return json_encode($promos);
    }
	
	
	public function allcoupons($userid,$promoid)
    {
        $coupons = Coupon::join('promos','coupons.promo_id','=','promos.id')
                            ->join('users','coupons.user_id','=','users.id')
                            ->select('coupons.*','promos.name as promo')
                            ->where(['coupons.promo_id' => $promoid,'coupons.user_id' => $userid])
                            ->get();
        return json_encode($coupons);
    }
	
	public function coupon($userid,$promoid,$couponid)
    {
        $coupon = Coupon::join('promos','coupons.promo_id','=','promos.id')
                            ->join('users','coupons.user_id','=','users.id')
                            ->select('coupons.*','promos.name as promo')
                            ->where(['coupons.promo_id' => $promoid,'coupons.user_id' => $userid,'coupons.id' => $couponid])
                            ->first();
        return json_encode($coupon);
    }
    
}
