<?php

namespace App\Http\Controllers\Coupon;

use Illuminate\Http\Request;
use App\User;
use App\UserTable;
use App\Promo;
use App\Coupon;
use App\SavedCoupons;
use App\PromoStats;
use App\Store;
use App\StoreUser;
use App\Media;
use Image;
use Auth;
use App\Notifications;
use App\Mail\ContentPosted;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\CouponRequest;
use App\Http\Requests;
use App\Http\Controllers\Controller;


use App\Classes\ExtraFunctions;


// image manipulations
// use Treinetic\ImageArtist\lib\Overlays\Overlay;
// use Treinetic\ImageArtist\lib\Text\Color;
// use Treinetic\ImageArtist\lib\Shapes\PolygonShape;
// use Treinetic\ImageArtist\lib\Commons\Node;
// use Treinetic\ImageArtist\lib\Image;
// use Treinetic\ImageArtist\lib\Shapes\Square;

class UserCouponController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('user');
    }

    public function index() {
        $view = view('user.coupons.coupon');
        $view->title = 'CouponCam::Coupons';

        $view->inactivePromos = Promo::join('promo_locations', 'promo_locations.promo_id','=','promos.promo_id')
            ->join('store_user', 'store_user.place_id','=','promo_locations.store_id')
            ->select('promos.*')
            ->distinct()
            ->where(['store_user.user_id' => Auth::id(), 'promo_locations.status' => 1, 'promos.status' => -1, 'promos.used' => '0'])
            ->orderBY('promos.updated_at', 'DESC')
            ->get();

        $activePromos = Promo::join('promo_locations', 'promo_locations.promo_id','=','promos.promo_id')
            ->join('store_user', 'store_user.place_id','=','promo_locations.store_id')
            ->select('promos.*')
            ->distinct()
            ->where(['store_user.user_id' => Auth::id(), 'promo_locations.status' => 1, 'promos.status' => 1, 'promos.used' => '1'])
            ->orderBY('promos.updated_at', 'DESC')
            ->get();

        $view->activePromos = $activePromos;

        $has_coupons = 0;

        if(sizeof($activePromos) > 0) {
            $has_coupons = 1;
        }

        $view->has_coupons = $has_coupons;

        $view->puasedPromos = Promo::join('promo_locations', 'promo_locations.promo_id','=','promos.promo_id')
            ->join('store_user', 'store_user.place_id','=','promo_locations.store_id')
            ->select('promos.*')
            ->distinct()
            ->where(['store_user.user_id' => Auth::id(), 'promo_locations.status' => 1, 'promos.status' => 0, 'promos.used' => '1'])
            ->orderBY('promos.updated_at', 'DESC')
            ->get();

        $view->allPromos = Promo::join('promo_locations', 'promo_locations.promo_id','=','promos.promo_id')
            ->join('store_user', 'store_user.place_id','=','promo_locations.store_id')
            ->select('promos.*')
            ->distinct()
            ->where(['store_user.user_id' => Auth::id(), 'promo_locations.status' => 1, 'promos.status' => 1, 'promos.used' => '1'])
            ->orWhere(['store_user.user_id' => Auth::id(), 'promo_locations.status' => 1, 'promos.status' => 0, 'promos.used' => '1'])
            ->orderBY('promos.updated_at', 'DESC')
            ->get();

        $view->coupons = Coupon::join('promo_locations', 'promo_locations.promo_id','=','coupons.promo_id')
            ->join('store_user', 'store_user.place_id','=','promo_locations.store_id')
            ->select('coupons.*')
            ->distinct()
            ->where(['store_user.user_id' => Auth::id(), 'promo_locations.status' => 1])
            ->orderBy('coupons.coupon_level', 'ASC')
            ->orderBy('coupons.updated_at', 'DECS')
            ->get();


        return $view;
    }

    public function upload_image(Request $request) {
        $data = $_POST['file'];

        $random = rand(0, 1000000);

        list($type, $data) = explode(';', $data);
        list(, $data)      = explode(',', $data);

        $data = base64_decode($data);

        $cp_image_path = 'resources/assets/coupons/full/';
        $image_name = 's'.date('Ymdhis').$random.".png";

        file_put_contents($cp_image_path.$image_name, $data);
        

        return $image_name;

    }

    public function create(CouponRequest $request){

        for($x = 1; $x < 5; $x++){

            // upload coupon photo
            $coupon_photo = '';
            // $new_photo = $request->get('cp_img_name_'.$x);

            $get_file = $request->get('cp_img_name_'.$x);

            $random = rand(0,1000000);
            $coup_img_name = 'c'.date('Ymdhis').$random.".png";
            $coup_img_path = 'resources/assets/coupons/full/';

            list($type, $get_file) = explode(';', $get_file);
            list(, $get_file)      = explode(',', $get_file);
            
            $get_file = base64_decode($get_file);
            
            // upload image
            file_put_contents($coup_img_path.$coup_img_name, $get_file);

            $coupon_photo = $coup_img_name;

            // check loyalty coupons
            $is_loyalty = 0;
            $loyalty_count = 0;
            if(isset($_POST['loyalty_coupon_'.$x])){
                $is_loyalty = 1;
                $loyalty_count = $request->get('coupon_count_'.$x);
            }

            //get min spend 
            $min_spend = 0;

            if($x == 1) {
                $min_spend = $request->get('min_spent_1');
            }

           // insert data
            $new_coup = new Coupon();

            $new_coup->coupon_title = trim($request->get('coupon_name_'.$x));
            $new_coup->estimated_value = trim($request->get('coupon_value_'.$x));
            $new_coup->coupon_availabilty = trim($request->get('coupon_availability_'.$x));
            $new_coup->terms_conditions = trim($request->get('coupon_condition_'.$x));
            $new_coup->coupon_information = trim($request->get('coupon_info_'.$x));
            $new_coup->promo_id = trim($request->get('promo_id_1'));
//            $new_coup->user_id = Auth::id();
            $new_coup->coupon_photo = $coupon_photo;
            $new_coup->coupon_model = trim($request->get('ar_coupon_name_'.$x));
            $new_coup->coupon_marker = trim($request->get('ar_marker_name_'.$x));
            $new_coup->is_loyalty = $is_loyalty;
            $new_coup->loyalty_count = $loyalty_count;
            $new_coup->coupon_level = $x;
            $new_coup->add_date = date('Y-m-d h:i:s');
            $new_coup->created_at = date('Y-m-d h:i:s');
            $new_coup->updated_at = date('Y-m-d h:i:s');
            $new_coup->min_spend = $min_spend;

            $new_coup->save();

        }

        $submit_form = $request->get('submit_type');

        if($submit_form == 1) {
            $id = Promo::where("promo_id",$request->get('promo_id_1'))->update(['used' => '1', 'status' => 1,"updated_at" => date('Y-m-d h:i:s')]);
        }
        else {
            $id = Promo::where("promo_id",$request->get('promo_id_1'))->update(['used' => '1', 'status' => 0,"updated_at" => date('Y-m-d h:i:s')]);
        }


        if($id) {
            return redirect('user/coupons')->with(['success' => 'Coupon created successfully']);
        } else {
            return back()->with(['error' => 'Coupon failed to create']);
        }
    }

    public function update(CouponRequest $request){
        for($x = 1; $x < 5; $x++){

            // upload coupon photo
            $cp_name = $request->get('cp_img_name_'.$x);
            $coupon_photo = '';
            if(strlen($cp_name) > 0) {

                $get_file = $request->get('cp_img_name_'.$x);

                $random = rand(0,1000000);
                $coup_img_name = 'c'.date('Ymdhis').$random.".png";
                $coup_img_path = 'resources/assets/coupons/full/';

                list($type, $get_file) = explode(';', $get_file);
                list(, $get_file)      = explode(',', $get_file);
                
                $get_file = base64_decode($get_file);
                
                // upload image
                file_put_contents($coup_img_path.$coup_img_name, $get_file);

                $coupon_photo = $coup_img_name;

            } else {
                $coupon_photo = $request->get('coup_img_'.$x);
            }

            // check loyalty coupons
            $is_loyalty = 0;
            $loyalty_count = 0;
            if(isset($_POST['loyalty_coupon_'.$x])){
                $is_loyalty = 1;
                $loyalty_count = $request->get('coupon_count_'.$x);
            }


            // update data
            Coupon::where("coupon_id",$request->get('coupon_id_'.$x))->update([
                "coupon_title" => trim($request->get('coupon_name_'.$x)),
                "estimated_value" => trim($request->get('coupon_value_'.$x)),
                "coupon_availabilty" => trim($request->get('coupon_availability_'.$x)),
                "terms_conditions" => trim($request->get('coupon_condition_'.$x)),
                "coupon_information" => trim($request->get('coupon_info_'.$x)),
                "promo_id" => trim($request->get('promo_id_1')),
//                "user_id" => Auth::id(),
                "coupon_photo" => $coupon_photo,
                "coupon_model" => trim($request->get('ar_coupon_name_'.$x)),
                "coupon_marker" => trim($request->get('ar_marker_name_'.$x)),
                "is_loyalty" => $is_loyalty,
                "loyalty_count" => $loyalty_count,
                "add_date" => date('Y-m-d h:i:s'),
                "created_at" => date('Y-m-d h:i:s'),
                "updated_at" => date('Y-m-d h:i:s')
            ]);


        }



        // update promo details
        $get_user_details = UserTable::where(['id' => Auth::id()])->get();
        $is_pre_launch = $get_user_details[0]->is_pre_launch;
        if($is_pre_launch == 1) {
          $id = Promo::where('promo_id',$request->get('promo_id_1'))->update(['used' => '1', 'status' => 3,'updated_at' => date('Y-m-d h:i:s') ]);
        }
        else {
          $id = Promo::where('promo_id',$request->get('promo_id_1'))->update(['used' => '1', 'status' => 1,'updated_at' => date('Y-m-d h:i:s') ]);
        }
        if($id) {
            return redirect('user/coupons')->with(['success' => 'Coupon Updated successfully']);
        } else {
            return back()->with(['error' => 'Coupon update Failed']);
        }
    }

    public function search_ar_coupon($input) {
        $result = Media::where('image_tags', 'like', '%'.$input.'%')->get();
        return($result);
    }

    public function search_coupons($input) {
        $coupons  = Coupon::join('promos', 'promos.promo_id','=','coupons.promo_id')
            ->select('promos.promo_name', 'promos.place_id', 'coupons.coupon_title','coupons.created_at')
            ->where('coupon_title', 'like', '%'.$input.'%')->get();

        foreach($coupons as $coupon) {
            $place_ids = $coupon->place_id;

            $remove_char = array("[","\"","]");
            $list = trim(str_replace($remove_char,"",$place_ids));
            $store_ids = explode(",", $list);

            $store_names = [];

            //$coupon->store_name = $store_ids;

            if(sizeof($store_ids) > 0){
                for($x = 0; $x < sizeof($store_ids); $x++){
                    $store_id = $store_ids[$x];
                    $get_store = Store::where(['place_id' => $store_id])->get();

                    $store_name = $get_store[0]['contact_name'];

                    array_push($store_names, $store_name);

                }

                $coupon->store_name = $store_names;
            }


        }

        return($coupons);
    }

    public function get_coupon_details($id){
        $coupons  = Coupon::where(['promo_id' => $id])->get();

        // get store details
        $get_curr = Store::join('promo_locations', 'promo_locations.store_id', '=', 'places.place_id')
            ->where(['promo_locations.promo_id' => $id])
            ->select('country_short')
            ->get()
            ->first();

        $country = $get_curr['country_short'];

        $curr_lbl = "$";

        if($country == "GB") {
            $curr_lbl = "£";
        }

        foreach($coupons as $coupon) {
            $coupon->cur_lable = $curr_lbl;
        }

        return($coupons);
    }

    public function get_curr_lable($promo_id) {
        $get_curr = Store::join('promo_locations', 'promo_locations.store_id', '=', 'places.place_id')
            ->where(['promo_locations.promo_id' => $promo_id])
            ->select('country_short')
            ->get()
            ->first();

        $country = $get_curr['country_short'];

        $curr_lbl = "$";

        if($country == "GB") {
            $curr_lbl = "£";
        }

        return $curr_lbl;
    }

}
