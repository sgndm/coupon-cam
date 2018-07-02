<?php
namespace App\Http\Controllers\Promo;

use Illuminate\Http\Request;
use Auth;
use App\Promo;
use App\PromoLocations;
use App\Store;
use App\StoreUser;
use App\User;
use App\Coupon;
use App\PromoStats;
use App\Notifications;
use App\Mail\ContentPosted;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\PromoRequest;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Classes\ExtraFunctions;
use App\Classes\Converter;

use Illuminate\Support\Facades\Storage;

use Treinetic\ImageArtist\lib\Overlays\Overlay;
use Treinetic\ImageArtist\lib\Text\Color;
use Treinetic\ImageArtist\lib\Shapes\PolygonShape;
use Treinetic\ImageArtist\lib\Commons\Node;
use Treinetic\ImageArtist\lib\Image;
use Treinetic\ImageArtist\lib\Shapes\Square;

///     date_default_timezone_set('Europe/London');

class UserPromoController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
        $this->middleware('user');
    }

    public function index(Request $request) {
        $view = view('user.promos.promo');
        $view->title = 'CouponCam::Promos';

        // get active stores
        $view->stores = Store::join('store_user', 'store_user.place_id', '=', 'places.place_id')
            ->where(['store_user.user_id' => Auth::id(), 'places.status' => '1'])
            ->orderBY('places.updated_at', 'DESC')
            ->get();

        $activePromos = Promo::join('promo_locations', 'promo_locations.promo_id','=','promos.promo_id')
            ->join('store_user', 'store_user.place_id','=','promo_locations.store_id')
            ->where(['store_user.user_id' => Auth::id(), 'promo_locations.status' => 1, 'promos.status' => 1, 'promos.used' => '1'])
            ->select('promos.*')
            ->distinct()
            ->orderBY('promos.updated_at', 'DESC')
            ->get();

        $view->activePromos = $activePromos;

        $has_promos = 0;

        if(sizeof($activePromos) > 0) {
            $has_promos = 1;
        }

        $store_id_new = 0;
        if(isset($request['store'])) {
            $store_id_new = $request['store'];
        }

        if($store_id_new > 0) {
            $has_promos = 0;
        }
        $view->new_store_id = $store_id_new;

        $view->has_promos = $has_promos;

        $view->puasedPromos = Promo::join('promo_locations', 'promo_locations.promo_id','=','promos.promo_id')
            ->join('store_user', 'store_user.place_id','=','promo_locations.store_id')
            ->where(['store_user.user_id' => Auth::id(), 'promo_locations.status' => 1, 'promos.status' => 0, 'promos.used' => '1'])
            ->select('promos.*')
            ->distinct()
            ->orderBY('promos.updated_at', 'DESC')
            ->get();

        $view->finishedPromos = Promo::join('promo_locations', 'promo_locations.promo_id','=','promos.promo_id')
            ->join('store_user', 'store_user.place_id','=','promo_locations.store_id')
            ->where(['store_user.user_id' => Auth::id(), 'promo_locations.status' => 1, 'promos.status' => 2, 'promos.used' => '1'])
            ->select('promos.*')
            ->distinct()
            ->orderBY('promos.updated_at', 'DESC')
            ->get();


        return $view;
    }

    public function generate_new_qr(){

        $save_path = 'resources/assets/qr_codes/';
        $file_name = 'qr'.date('YmdHis').rand(0, 10000).".png";
        $content = 'qr_code_' . rand(0, 100000000).date('YmdHis');

        $service_url = 'https://qrcode-monkey.p.mashape.com/qr/custom';

        $curl = curl_init($service_url);
        $curl_post_data = array(
            'data' => $content,
            'config' => array(
                "body" => "circle",
                "eye" => "frame12",
                "eyeBall" => "ball14",
                "erf1" => [],
                "erf2" => [],
                "erf3" => [],
                "brf1" => [],
                "brf2" => [],
                "brf3" => [],
                "bodyColor" => "#e80602",
                "bgColor" => "#fff",
                "eye1Color" => "#e80602",
                "eye2Color" => "#e80602",
                "eye3Color" => "#e80602",
                "eyeBall1Color" => "#e80602",
                "eyeBall2Color" => "#e80602",
                "eyeBall3Color" => "#e80602",
                "gradientColor1" => "",
                "gradientColor2" => "",
                "gradientType" => "linear",
                "gradientOnEyes" => "false",
                "logo" => "http://login.couponcam.com/resources/assets/custom/images/logo-min.png"
            ),
            'size' => 300,
            'download' => 'false',
            'file' => 'png',
        );

        $post_data = json_encode($curl_post_data);

        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'X-Mashape-Key: yxBNWNKhItmshiOORWMsvumwIm8tp1AMo56jsnzJ7zEWZ1F3y9',
            'Content-Type: application/json',
            'Accept: application/json'
        ));

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);

        $curl_response = curl_exec($curl);


        $decoded = base64_encode($curl_response);

        $image_qr = new Image('data:image/png;base64,'.$decoded);
        $image_qr->save($save_path.$file_name,IMAGETYPE_PNG);






        // new qr for new promo


//        QrCode::format('png')->size(500)->color(232,6,2)->merge('resources/assets/custom/images/logo-min.png', .3, true)->errorCorrection('H')->generate($content, $save_path.$file_name);

        $return = array('qr_content' => $content,'qr_image' => $file_name);

        return ($return);
    }

    public function delete_old_qr($file){
        $path = 'resources/assets/qr_codes/'.$file;
        Storage::delete($path);
    }

    public function create_promo(PromoRequest $request) {

        // get server time
        $server_location = Converter::get_server_location();
        $server_lat = $server_location['latitude'];
        $server_lng = $server_location['longitude'];

        $server_offset = Converter::get_time_zone($server_lat,$server_lng);

        // get stores
        $getstores = json_encode($request->store_ids_1);

        $removeChar = array("[","]","\"");
        $stmst = trim(str_replace($removeChar, "", $getstores));

        $get_store_list = explode(',',$stmst);

        $store_id_1 = $get_store_list[0];

        // get store details by store id
        $store_details = ExtraFunctions::get_store_details($store_id_1);

        $country = $store_details['country'];
        $lat = $store_details['latitude'];
        $lng = $store_details['longitude'];

        //get time zone
        $get_offset = Converter::get_time_zone($lat,$lng);

        $get_start_time = date("H:i:s", strtotime($request->promo_start));
        $promo_length = $request->promo_length;
        $get_end_time = date('H:i:s',strtotime("+$promo_length hour",strtotime($get_start_time)));
        $advance_warn = 0;

        $start_time = Converter::get_server_time_by_local_time($get_start_time, $get_offset, $server_offset);
        $end_time = Converter::get_server_time_by_local_time($get_end_time, $get_offset, $server_offset);

        $advance_warn = 1;
        // if(isset($request->advance_warning)){
        //     $advance_warn = 1;
        // }

        $promo_repete = $request->repeat_promo_1;
        $promo_repeate_val = "";


        if($promo_repete == 'Days'){

            $promo_repeate_val = json_encode($request->days_1);

        }elseif($promo_repete == 'Date'){

            $promo_repeate_val = date("Y-m-d H:i:s", strtotime($request->promo_date));

        }


        $promo_id = Promo::insertGetId([
            'promo_name' => trim($request->promo_name),
//            'user_id' => Auth::id(),
            'start_at' => gmdate("H:i:s", strtotime($start_time)),
            'start_at_local' => gmdate("H:i:s", strtotime($get_start_time)),
            'end_at' => gmdate("H:i:s", strtotime($end_time)),
            'end_at_local' => gmdate("H:i:s", strtotime($get_end_time)),
            'promo_length' => $promo_length,
            'advance_warning' => $advance_warn,
            'main_clue' => '',
            'promo_repeat' => $promo_repete,
            'promo_repeat_values' => $promo_repeate_val,
            'internal_promo'  => 1,
            'place_id' => json_encode($request->store_ids_1),
//            'qr_code' => $request->promo_qr_code,
//            'qr_image' => $request->promo_qr_image,
            'add_date' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        if($promo_id){

            $store_locations = [];

            $stores = json_encode($request->store_ids_1);

            $remove = array("[","]","\"");
            $stm = trim(str_replace($remove, " ", $stores));

            $store_list = explode(',',$stm);

            for($n = 0; $n < sizeof($store_list); $n++){

                $stId = (int)$store_list[$n];



                $is_outside = $request->get('store_loc_'.$stId);
                //  echo $stId."-".$is_outside."<br>";

                if($is_outside == 1){
                    $lat = $request->get('store_lat_'.$stId);
                    $lng = $request->get('store_lng_'.$stId);
                    $xxx  = '1';
                }else{
                    $inst = Store::where("place_id",$stId)->first();
                    $lat = $inst->latitude;
                    $lng = $inst->longitude;
                    $xxx  = '0';
                }

                $store_locations[] = [
                    'promo_id' => $promo_id,
                    'store_id' => $stId,
                    'lat_code' => $lat,
                    'lng_code' => $lng,
                    'is_outside' => $xxx
                ];
            }

            PromoLocations::insert($store_locations);

            return redirect('user/coupons?promo='. $promo_id)->with(['success' => 'Promo Created successfully']);
        }  else {
            return back()->with(['error' => 'Promo failed to create']);
        }


    }

    public function update_promo(PromoRequest $request){

        if(isset($_POST['pause_promo'])) {
            $promo_id = Promo::where("promo_id",$request->formid)
                ->update([
                    'status' => 0,
                    'updated_at' => date('Y-m-d h:i:s')

                ]);

            if($promo_id){
                return redirect('user/promos')->with(['success' => 'Promo Puased successfully']);
            }  else {
                return back()->with(['error' => 'Promo failed to pause']);
            }
        }
        else {

            // get server time
            $server_location = Converter::get_server_location();
            $server_lat = $server_location['latitude'];
            $server_lng = $server_location['longitude'];

            $server_offset = Converter::get_time_zone($server_lat,$server_lng);

            // get stores
            $get_store_list = PromoLocations::where(['promo_id' => $request->formid])->get();
            $store_lat = $get_store_list[0]->lat_code;
            $store_lng = $get_store_list[0]->lng_code;

            //get time zone
            $get_offset = Converter::get_time_zone($store_lat,$store_lng);

            $get_start_time = date("H:i:s", strtotime($request->promo_start));
            $promo_length = $request->promo_length;
            $get_end_time = date('H:i:s',strtotime("+$promo_length hour",strtotime($get_start_time)));
            $advance_warn = 0;

            $start_time = Converter::get_server_time_by_local_time($get_start_time, $get_offset, $server_offset);
            $end_time = Converter::get_server_time_by_local_time($get_end_time, $get_offset, $server_offset);


            $advance_warn = 1;
            // if(isset($request->advance_warning)){
            //     $advance_warn = 1;
            // }

            $promo_repete = $request->repeat_promo_2;
            $promo_repeate_val = "";


            if($promo_repete == 'Days'){

                $promo_repeate_val = json_encode($request->days_2);

            }elseif($promo_repete == 'Date'){

                $promo_repeate_val = date("Y-m-d H:i:s", strtotime($request->promo_date));

            }


            $promo_id = Promo::where("promo_id",$request->formid)
                ->update([
                    'promo_name' => trim($request->promo_name),
//                    'user_id' => Auth::id(),
                    'start_at' => gmdate("H:i:s", strtotime($start_time)),
                    'start_at_local' => gmdate("H:i:s", strtotime($get_start_time)),
                    'end_at' => gmdate("H:i:s", strtotime($end_time)),
                    'end_at_local' => gmdate("H:i:s", strtotime($get_end_time)),
                    'promo_length' => $promo_length,
                    'advance_warning' => $advance_warn,
                    'main_clue' => $request->promo_description,
                    'promo_repeat' => $promo_repete,
                    'promo_repeat_values' => $promo_repeate_val,
                    'internal_promo'  => 1,
//                    'qr_code' => $request->promo_qr_code,
//                    'qr_image' => $request->promo_qr_image,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);



            // update promo locations

            $store_locations = [];

            $stores = json_encode($request->store_ids_2);

            $remove = array("[","]","\"");
            $stm = trim(str_replace($remove, " ", $stores));

            $store_list = explode(',',$stm);

            if(sizeof($store_list) > 0 ) {
                // get promo locations old
                $up_promo_id = $request->formid;

                PromoLocations::where(['promo_id' => $up_promo_id])->delete();

                for($n = 0; $n < sizeof($store_list); $n++){

                    $stId = (int)$store_list[$n];

                    $is_outside = $request->get('store_loc_'.$stId);
                      echo $stId."-".$is_outside."<br>";

                    if($is_outside == 1){
                        $lat = $request->get('store_lat_'.$stId);
                        $lng = $request->get('store_lng_'.$stId);
                        $xxx  = '1';
                    }else{
                        $inst = Store::where("place_id",$stId)->first();
                        $lat = $inst->latitude;
                        $lng = $inst->longitude;
                        $xxx  = '0';
                    }

                    $store_locations[] = [
                        'promo_id' => $up_promo_id,
                        'store_id' => $stId,
                        'lat_code' => $lat,
                        'lng_code' => $lng,
                        'is_outside' => $xxx
                    ];
                }

                PromoLocations::insert($store_locations);
            }


            if($promo_id){
                return redirect('user/promos')->with(['success' => 'Promo Updated successfully']);
            }  else {
                return back()->with(['error' => 'Promo failed to update']);
            }

        }


    }

    // finish promo
    public function delete_promo(PromoRequest $request){
        if(isset($_POST['finish_promo'])){
            $promo_id = Promo::where("promo_id",$request->formid)
                ->update([
                    'status' => 2,
                    'updated_at' => date('Y-m-d h:i:s')

                ]);

            if($promo_id){
                return redirect('user/promos')->with(['success' => 'Promo finished successfully']);
            }  else {
                return back()->with(['error' => 'Promo failed to finish']);
            }
        }
        else {
            $promo_id = Promo::where("promo_id",$request->formid)
                ->update([
                    'status' => 1,
                    'updated_at' => date('Y-m-d h:i:s')

                ]);

            if($promo_id){
                return redirect('user/promos')->with(['success' => 'Promo reactivated successfully']);
            }  else {
                return back()->with(['error' => 'Promo failed to reactivate']);
            }
        }

    }

    public function get_promo_details($id) {
        $response = array('status' => '','details' => '');
        $remove_char = array("[","\"","]");

        $promo_details = Promo::where(['promo_id' => $id])
            ->get();

        $promo_repeat = $promo_details[0]->promo_repeat;
        $repeat_vals = trim($promo_details[0]->promo_repeat_values);

        if($promo_repeat == "Days"){
            $list = trim(str_replace($remove_char,"",$repeat_vals));
            $promo_repeate_values = explode(",", $list);

            $promo_details[0]->promo_repeat_values = $promo_repeate_values;
        }



        $place_ids = $promo_details[0]->place_id;

        $list2 = trim(str_replace($remove_char,"",$place_ids));
        $stores = explode(",", $list2);

        $promo_details[0]->place_id = $stores;

        // get promo_locations
        $pr_locs = PromoLocations::where(['promo_id' => $id])->get();

        $promo_details[0]->locations = $pr_locs;

        if(sizeof($promo_details) > 0) {

            $response['status'] = 1;
            $response['details'] = $promo_details;
        } else {
            // return empty //
            $response['status'] = 0;

        }

        return($response);

    }

    public function get_promo_stats($id) {
        // get total days running
        $get_days_running = Promo::where('promo_id', $id)->select('days_running')->get();
        $days_running = $get_days_running[0]->days_running;

        // calculate coupons issued
        // stats for all time promo
        // get different device id that saved yesterday
        $get_svd_a_all_time = PromoStats::where(['promo_id' => $id])->select('device_id')->distinct()->get();


        $coupons_issued = 0;

        // for every saved device
        foreach ($get_svd_a_all_time as $svd_y) {
            $temp_svd_dv_id = $svd_y->device_id;

            // get different coupon ids for this promo and device
            $temp_coup_ids = PromoStats::where(['promo_id' => $id,'device_id' => $temp_svd_dv_id])->select('coupon_id')->distinct()->orderBy('coupon_id','ASC')->get();

            // get count for each coup
            foreach ($temp_coup_ids as $temp_coups) {
                // coupon_id
                $t_coup_id = $temp_coups->coupon_id;

                // get count for this coupon
                $temp_cp_count = PromoStats::where(['device_id' => $temp_svd_dv_id, 'coupon_id' => $t_coup_id])->count();

                $coupons_issued += $temp_cp_count;
            }
        }

        // get new customers
        $get_new_customers = 0;
        $gnc_a_customers = PromoStats::where(['promo_id' => $id])->select('device_id')->distinct()->get();
        $get_new_customers += sizeof($gnc_a_customers);
        // end promo stats all time

        $revisits = 0;
        // get revisit count
        foreach ($gnc_a_customers as $customers) {
            // get total record count
            $t_t_r_c = PromoStats::where(['promo_id' => $id , 'device_id' => $customers->device_id])->count();

            $revisits += ($t_t_r_c - 1);
        }

        $res = [
            'days_running' => $days_running,
            'coupons_issued' => $coupons_issued,
            'new_customers' => $get_new_customers,
            'revisits' => $revisits,
            'other' => $get_new_customers
        ];

        return($res);
    }

    public function search_promos($input){
        $promos  = Promo::where('promo_name', 'like', '%'.$input.'%')->get();

        foreach($promos as $promo) {
            $place_ids = $promo->place_id;

            $remove_char = array("[","\"","]");
            $list = trim(str_replace($remove_char,"",$place_ids));
            $store_ids = explode(",", $list);

            $store_names = [];

            //$promo->store_name = $store_ids;

            if(sizeof($store_ids) > 0){
                for($x = 0; $x < sizeof($store_ids); $x++){
                    $store_id = $store_ids[$x];
                    $get_store = Store::where(['place_id' => $store_id])->get();

                    $store_name = $get_store[0]['contact_name'];

                    array_push($store_names, $store_name);

                }

                $promo->store_name = $store_names;
            }


        }

        return($promos);
    }

    public function get_active_promos() {
        $promos = Promo::join('promo_locations', 'promo_locations.promo_id', '=', 'promos.promo_id')
            ->select('promos.promo_id','promos.promo_name', 'promo_locations.*')
            ->where(['promos.status' => '1', 'promos.used' => '1'])
            ->get();

        return ($promos);
    }

     public function get_inactive_promos() {
        $promos = Promo::join('promo_locations', 'promo_locations.promo_id', '=', 'promos.promo_id')
            ->select('promos.promo_id','promos.promo_name', 'promo_locations.*')
            ->where(['promos.status' => '0', 'promos.used' => '1'])
            ->get();

        return ($promos);
    }




}
