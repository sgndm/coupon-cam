<?php

namespace App\Http\Controllers\Promo;

use DB;

use App\UserTable;
use Illuminate\Http\Request;
use Auth;
use App\Promo;
use App\PromoLocations;
use App\User;
use App\Store;
use App\Coupon;
use App\RedPromo;
use App\RedCoupon;
use App\Http\Requests\PromoRequest;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Classes\ExtraFunctions;
use App\Classes\Converter;
use App\AppSettings;

use Treinetic\ImageArtist\lib\Overlays\Overlay;
use Treinetic\ImageArtist\lib\Text\Color;
use Treinetic\ImageArtist\lib\Shapes\PolygonShape;
use Treinetic\ImageArtist\lib\Commons\Node;
use Treinetic\ImageArtist\lib\Image;
use Treinetic\ImageArtist\lib\Shapes\Square;


use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PromoController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        //$this->middleware('admin');
    }

    public function index() {
        $view = view('admin.promos.promo_list');
        $view->title = 'List of promos';

        $view->promos = Promo::join('promo_locations', 'promo_locations.promo_id', '=', 'promos.promo_id')
            ->join('store_user', 'store_user.place_id', '=', 'promo_locations.store_id')
            ->select('promos.*')
            ->distinct()
            ->where(['promos.status' => '1','promos.used' => '1'])
            ->get();

        return $view;
    }

    public function closed() {
        $view = view('admin.promos.promo_list_closed');
        $view->title = 'List of closed promos';
        $view->promos = Promo::join('promo_locations', 'promo_locations.promo_id', '=', 'promos.promo_id')
            ->join('store_user', 'store_user.place_id', '=', 'promo_locations.store_id')
            ->select('promos.*')
            ->distinct()
            ->where(['promos.status' => '0','promos.used' => '1'])
            ->get();
        return $view;
    }

    public function create() {
        $view = view('admin.promos.promo_create');
        $view->title = 'New promo';
        $view->users  = User::where(['active' => '1', 'usertype' => '0'])->select(['id','name'])->get();
        $view->stores = Store::where(['status' => '1'])->get();
        $view->promos = Promo::where(['status' => '1'])->get();
        return $view;
    }

    public function createbyid($id) {
        $view = view('admin.promos.promo_create_id');
        $view->title = 'New promo';
        $view->users  = User::where(['active' => '1', 'usertype' => '1'])->select(['id','name'])->get();
        $view->stores = Store::where(['status' => '1'])->get();
        $view->promos = Promo::where(['status' => '1'])->get();
        $view->promo = Promo::where(['promo_id' => $id])->first();
        return $view;
    }

    public function generate_new_qr() {

        $save_path = 'resources/assets/qr_codes/';
        $file_name = 'qr'.date('YmdHis').rand(0, 10000).".png";
        $content = rand(0, 100000000).date('YmdHis');

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

        $return = array('qr_content' => $content,'qr_image' => $file_name);

        return ($return);
    }

    public function save(PromoRequest $request) {

        // get server time
        $server_location = Converter::get_server_location();
        $server_lat = $server_location['latitude'];
        $server_lng = $server_location['longitude'];

        $server_offset = Converter::get_time_zone($server_lat,$server_lng);

        // get stores
        $getstores = json_encode($request->store_name);

        $removeChar = array("[","]","\"");
        $stmst = trim(str_replace($removeChar, "", $getstores));

        $get_store_list = explode(',',$stmst);

        $store_id_1 = $get_store_list[0];

        // get store details by store id
        $store_details = ExtraFunctions::get_store_details($store_id_1);

        // $country = $store_details['country'];
        $lat = $store_details['latitude'];
        $lng = $store_details['longitude'];

        //get time zone
        $get_offset = Converter::get_time_zone($lat,$lng);

        $get_start_time = date("H:i:s", strtotime($request->promo_start));
        $promo_length = $request->promo_lenght;
        $get_end_time = date('H:i:s',strtotime("+$promo_length hour",strtotime($get_start_time)));
        $advance_warn = 0;

        $start_time = Converter::get_server_time_by_local_time($get_start_time, $get_offset, $server_offset);
        $end_time = Converter::get_server_time_by_local_time($get_end_time, $get_offset, $server_offset);

        // $start_time 			= date("H:i:s", strtotime($request->promo_start));
        // $promo_length			= $request->promo_lenght;
        // $end_time			= date('H:i:s',strtotime("+$promo_length hour",strtotime($start_time)));
        // $advance_warn_hr		= $request->advance_warning;
        // $warn_start_time 		= date('H:i:s',strtotime("-$advance_warn_hr hour",strtotime($start_time)));

        $xm = "";
        if($request->repeat_promo == 'Days'){
            $xm = json_encode($request->days);
        }elseif($request->repeat_promo == 'Date'){
            $xm = date("Y-m-d", strtotime($request->promo_date));
        }else{
            $xm = '';
        }

        $ad_warn = 0;
        if(isset($_POST['advance_warning'])) {
            $ad_warn = 1;
        }


        $id = Promo::insertGetId([
            'promo_name' => trim($request->name),
//                'user_id' => $request->company_name,
            'start_at' => gmdate("H:i:s", strtotime($start_time)),
            'start_at_local' => gmdate("H:i:s", strtotime($get_start_time)),
            'end_at' => gmdate("H:i:s", strtotime($end_time)),
            'end_at_local' => gmdate("H:i:s", strtotime($get_end_time)),
            'promo_length' => $request->promo_lenght,
            'advance_warning' => $ad_warn,
            'main_clue' => $request->promo_desc,
            'promo_repeat' => $request->repeat_promo,
            'promo_repeat_values' => $xm,
            'internal_promo'  => 1,
            'place_id' => json_encode($request->store_name),
            'add_date' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'status' => 3
        ]);

        if($id){

            $store_locations = [];
            for($n = 0; $n < count($request->store_name); $n++){
                $stid = (int) $request->get('store_name')[$n];
                if(isset($_POST['store_outside_'.$stid])){
                    $lat = $request->get('store_lat_'.$stid);
                    $lng = $request->get('store_lng_'.$stid);
                    $xxx  = '0';
                }else{
                    $inst = Store::where("place_id",$stid)->first();
                    $lat = $inst->latitude;
                    $lng = $inst->longitude;
                    $xxx  = '1';
                }

                $store_locations[] = [
                    'promo_id' => $id,
                    'store_id' => $request->get('store_name')[$n],
                    'lat_code' => $lat,
                    'lng_code' => $lng,
                    'is_outside' => $xxx
                ];
            }

            PromoLocations::insert($store_locations);

            return redirect('admin/promos')->with(['success' => 'Promo Created successfully']);
        }  else {
            return back()->with(['error' => 'Promo failed to create']);
        }
    }

    public function edit($id) {
        \App\Notifications::where([['msgfrom','promo'],['recordid',$id]])->update(['active' => '0']);
        $view = view('admin.promos.promo_edit');
        $view->title = 'Edit promo';
        $view->promo = Promo::where(['promo_id' => $id])->first();
        $view->stores = Store::where(['status' => '1'])->get();
        $view->users   = User::where(['active' => '1', 'usertype' => '1'])->select(['id','name'])->get();
        return $view;
    }

    public function update(PromoRequest $request) {

        $start_time 			= date("H:i:s", strtotime($request->promo_start));
        $promo_length			= $request->promo_lenght;
        $end_time			= date('H:i:s',strtotime("+$promo_length hour",strtotime($start_time)));
        $advance_warn_hr		= $request->advance_warning;
        $warn_start_time 		= date('H:i:s',strtotime("-$advance_warn_hr hour",strtotime($start_time)));

        $xm = "";
        if($request->repeat_promo == 'Days'){
            $xm = json_encode($request->days);
        }elseif($request->repeat_promo == 'Date'){
            $xm = date("Y-m-d H:i:s", strtotime($request->promo_date));
        }else{
            $xm = '';
        }

        $id = Promo::where("promo_id",$request->formid)->update([
            'promo_name' => trim($request->name),
            'user_id' => $request->company_name,
            'start_at' => gmdate("H:i:s", strtotime($start_time)),
            'end_at' => gmdate("H:i:s", strtotime($end_time)),
            'promo_length' => $request->promo_lenght,
            'advance_warning' => $request->advance_warning,
            'main_clue' => $request->promo_desc,
            'warning_start_time' => gmdate("H:i:s", strtotime($warn_start_time)),
            'promo_repeat' => $request->repeat_promo,
            'promo_repeat_values' => $xm,
            'status' => $request->active,
            'internal_promo'  => 1,
            'place_id' => json_encode($request->store_name),
            'add_date' => date('Y-m-d h:i:s'),
            'created_at' => date('Y-m-d h:i:s'),
            'updated_at' => date('Y-m-d h:i:s')
        ]);

        if($id){
            PromoLocations::where("promo_id",$request->formid)->delete();
            $store_locations = [];

            for($n = 0; $n < count($request->store_name); $n++){
                $stid = (int) $request->get('store_name')[$n];
                if(isset($_POST['store_outside_'.$stid])){
                    $lat = $request->get('store_lat_'.$stid);
                    $lng = $request->get('store_lng_'.$stid);
                    $xxx  = '1';
                }else{
                    $inst = Store::where("place_id",$stid)->first();
                    $lat = $inst->latitude;
                    $lng = $inst->longitude;
                    $xxx  = '0';
                }

                $store_locations[] = [
                    'promo_id' => $request->formid,
                    'store_id' => $request->get('store_name')[$n],
                    'lat_code' => $lat,
                    'lng_code' => $lng,
                    'is_outside' => $xxx,
                ];
            }
            PromoLocations::insert($store_locations);

            return redirect('admin/promos')->with(['success' => 'Promo Updated successfully']);
        }  else {
            return back()->with(['error' => 'Promo failed to create']);
        }
    }

    public function delete($id) {
        $x = Promo::where("promo_id",$id)->update(["status" => '0']);

        if($x){
            return redirect('admin/promos')->with(['success' => 'Promo Trashed successfully']);
        }  else {
            return back()->with(['error' => 'Promo failed to trashed']);
        }
    }

    public function restore($id) {
        $x = Promo::where("promo_id",$id)->update(["status" => '1']);

        if($x){
            return redirect('admin/promos/trash')->with(['success' => 'Promo Restored successfully']);
        }  else {
            return back()->with(['error' => 'User failed to restore']);
        }
    }
    public function trash() {
        $view = view('admin.promos.promo_trash');
        $view->title = 'Trash';
        $view->promos = Promo::where('status','0')->get();
        return $view;
    }

    public function clear($id) {
        \App\Coupon::where(['promo_id' => $id])->delete();
        Promo::where(['promo_id' => $id])->delete();
        return redirect('admin/promos')->with(['success' => 'Promo Deleted successfully']);
    }

    public function storesbyuser($company){

        $stores = Store::join('store_user', 'store_user.place_id', '=', 'places.place_id')
            ->where(['store_user.user_id' => $company, 'status' => 1])
            ->select('places.place_id','places.contact_name','places.latitude','places.longitude')
            ->get();

        $html = '';


        foreach ($stores as $key => $store) {
            $lat = $store->latitude;
            $lng = $store->longitude;

            $html .= '<div class="form-group" style="border-bottom: #e4e4e4 solid 1px; margin-top: 15px;"><div class="col-sm-8">';
            $html .= '<input type="checkbox" id="store_select_'.$store->place_id.'" name="store_name[]" value="'.$store->place_id.'"> ';
            $html .= $store->contact_name;
            $html .= '</div>';
            $html .= '<div class="col-sm-4" style="background-color: #f5f5f5; padding: 1px 10px;"><input type="radio" checked="checked" onchange="ShowMap('.$store->place_id.')" name="store_outside_'.$store->place_id.'" value=""> <small style="margin-right: 20px;">Outside Store</small><br> <input type="radio"  id="store_outside_'.$store->place_id.'" onchange="ShowMap('.$store->place_id.')" name="store_outside_'.$store->place_id.'" value="'.$store->place_id.'"> <small>Somewhere Else</small></div>';
            $html .= '<div class="clearfix"></div><input type="hidden" class="form-control" id="store_name_'.$store->place_id.'" name="store_name_'.$store->place_id.'" value="'.$store->contact_name.'">';
            $html .= '<input type="hidden" id="store_lat_'.$store->place_id.'" name="store_lat_'.$store->place_id.'" value="'.$lat.'">';
            $html .= '<input type="hidden" id="store_lng_'.$store->place_id.'" name="store_lng_'.$store->place_id.'" value="'.$lng.'">';
            $html .= '<input type="hidden" id="store_id_'.$store->place_id.'" name="store_id_'.$store->place_id.'" value="'.$store->place_id.'">';
            $html .= '</div><div class="showmaphere_'.$store->place_id.'"><input type="text" style="display:none" class="form-control" id="store_address_'.$store->place_id.'" name="store_address_'.$store->place_id.'" value=""><div class="promo_map_'.$store->place_id.'" id="promo_map_'.$store->place_id.'" style="width: 100%; height: 300px; margin-top: 15px; display: none;"></div></div>';
        }
        return $html;
    }

    public function storesbyuser_pid($company,$promoid){

        $stores = Store::where(['user_id' => $company,'status' => 1])->select('place_id','contact_name','latitude','longitude')->get();
        $promo  = Promo::where("promo_id",$promoid)->first();
        $html = '';


        foreach ($stores as $key => $store) {

            $lat = $store->latitude;
            $lng = $store->longitude;
            $chme = "";
            $btn = "";
            $display = "none";
            $html .= '<div class="form-group" style="border-bottom: #e4e4e4 solid 1px; margin-top: 15px;"><div class="col-sm-8">';

            $chme1 = 'checked="checked"';
            $chme2 = '';

            if(in_array($store->place_id,json_decode($promo->place_id)) == true){

                $prm = PromoLocations::where([["promo_id",$promoid],["store_id",$store->place_id],["is_outside","1"]])->first();

                if($prm){

                    $lat = $prm->lat_code;
                    $lng = $prm->lng_code;
                    $chme2 = 'checked="checked"';
                    $chme1 = '';
                    $display = "block";
                    $btn = '<button type="button" onclick="ShowMap('.$store->place_id.'); $(this).hide();" class="btn btn-xs btn-primary pull-right"><small>Show Map</small></button>';
                }
                $html .= '<input type="checkbox" id="store_select_'.$store->place_id.'" name="store_name[]" value="'.$store->place_id.'" checked="checked"> ';
                $html .= $store->contact_name;
                $html .= '</div>';
                $html .= '<div class="col-sm-4" style="background-color: #f5f5f5; padding: 1px 10px;" ><input type="radio" '.$chme1.' onchange="ShowMap('.$store->place_id.')" name="store_outside_'.$store->place_id.'" value=""> <small style="margin-right: 20px;">Outside Store</small> <br><input type="radio" '.$chme2.' id="store_outside_'.$store->place_id.'" onchange="ShowMap('.$store->place_id.')" name="store_outside_'.$store->place_id.'" value="'.$store->place_id.'"> <small>Somewhere Else</small></div>'.$btn;
            }else{
                $html .= '<input type="checkbox" id="store_select_'.$store->place_id.'" name="store_name[]" value="'.$store->place_id.'"> ';
                $html .= $store->contact_name;
                $html .= '</div>';
                $html .= '<div class="col-sm-4" style="background-color: #f5f5f5; padding: 1px 10px;" ><input type="radio" '.$chme1.' onchange="ShowMap('.$store->place_id.')" name="store_outside_'.$store->place_id.'" value=""> <small style="margin-right: 20px;">Outside Store</small><br> <input type="radio" '.$chme2.' id="store_outside_'.$store->place_id.'" onchange="ShowMap('.$store->place_id.')" name="store_outside_'.$store->place_id.'" value="'.$store->place_id.'"> <small>Somewhere Else</small></div>'.$btn;
            }

            $html .= '<div class="clearfix"></div><input type="hidden" class="form-control" id="store_name_'.$store->place_id.'" name="store_name_'.$store->place_id.'" value="'.$store->contact_name.'">';
            $html .= '<input type="hidden" id="store_lat_'.$store->place_id.'" name="store_lat_'.$store->place_id.'" value="'.$lat.'">';
            $html .= '<input type="hidden" id="store_lng_'.$store->place_id.'" name="store_lng_'.$store->place_id.'" value="'.$lng.'">';
            $html .= '<input type="hidden" id="store_id_'.$store->place_id.'" name="store_id_'.$store->place_id.'" value="'.$store->place_id.'">';
            $html .= '</div><div class="showmaphere_'.$store->place_id.'"><input type="text" style="display:none" class="form-control" id="store_address_'.$store->place_id.'" name="store_address_'.$store->place_id.'" value=""><div class="promo_map_'.$store->place_id.'" id="promo_map_'.$store->place_id.'" style="width: 100%; height: 300px; margin-top: 15px; display: none;"></div></div>';
        }
        return $html;
    }


    public function redPromoCreate() {
        $view = view('admin.promos.red_promos');
        $view->title = "Red Friday Promos";

        return ($view);
    }

    public function redPromoList() {
        $view = view('admin.promos.red_promos_list');
        $view->title = "Red Friday Promos List";
        $view->active_promos = RedPromo::where(['status' => 1, 'used' => 1])->get();
        $view->inactive_promos = RedPromo::where(['status' => 0, 'used' => 1])->get();
        return ($view);
    }

    public function redPromoSave(Request $request) {
        // get start date
        $get_st_date = date('Y-m-d H:i:s', strtotime(($request->start_date) . " " . ($request->promo_start)));

        // calculate end time for red promo
        $get_start_at  = date('H:i:s', strtotime($request->promo_start));
        $promo_length = trim($request->promo_lenght);
        // end time
        $get_end_at = date('H:i:s',strtotime("+$promo_length min",strtotime($get_start_at)));

        // get server time
        $server_location = Converter::get_server_location();
        $server_lat = $server_location['latitude'];
        $server_lng = $server_location['longitude'];

        $server_offset = Converter::get_time_zone($server_lat,$server_lng);

        // red promo location
        $lat_r = trim($request->promo_lat);
        $lng_r = trim($request->promo_lng);
        $country_r = trim($request->promo_country);

        $get_offset = Converter::get_time_zone($lat_r,$lng_r);

        $start_time = Converter::get_server_time_by_local_time($get_start_at, $get_offset, $server_offset);
        $end_time = Converter::get_server_time_by_local_time($get_end_at, $get_offset, $server_offset);

        $get_new_time = Converter::get_server_new_time($get_st_date, $get_offset, $server_offset);

        $st_ser_date = date('Y-m-d', strtotime($get_new_time));

        // validate image
        $this->validate($request, [
            'red_photo' => 'required|image|mimes:jpeg,png,jpg',
            'red_promo_model' => 'required|image|mimes:jpeg,png,jpg'
        ]);

        // upload image
        $promo_img = '';
        if($request->hasFile('red_photo')) {
            $image = $request->file('red_photo');
            $filename = 'red_'.time() . '_promo.' . $image->getClientOriginalExtension();
            $path = 'resources/assets/red_promos/';

            // move image to asset
            $image->move($path,$filename);

            $promo_img = $filename;
        }

        // red promo model
        $promo_ar = '';
        $promo_marker = '';
        if($request->hasFile('red_promo_model')) {
            $image = $request->file('red_promo_model');
            $filename = 'red_'.time() . '_model.' . $image->getClientOriginalExtension();
            $path = 'resources/assets/red_promos/';

            // move image to asset
            $image->move($path,$filename);

            $ar_img = new Image($path.$filename);
            $ar_img->resize(300,300);
            $ar_img->save($path.$filename,IMAGETYPE_PNG);

            $promo_ar = $filename;

            // create a marker
            $marker_name = 'marker' . time() . '.png';
            $img_1 = new Image($path.$filename);
            $img_1->scale(60);
            $img_2 = new Image('resources/assets/custom/images/marker.png');
            $img_2->merge($img_1,170,60);
            $img_2->resize(300,300);
            $img_2->save($path.$marker_name,IMAGETYPE_PNG);

            $promo_marker = $marker_name;
        }


        $is_pre_launch = 0;
        // check for special promos
        if(isset($request->give_away)) {
            $is_pre_launch = 1;

            $date_d = date("Y-m-d", strtotime(trim($request->start_date)));
            $time_t = date('H:i:s', strtotime($start_time));

            $main_dt = date("Y-m-d H:i:s", strtotime($date_d ." ". $time_t));

            $update = AppSettings::where(['setting_name' => 'is_main_ready'])->update([
                'date' => $main_dt
            ]);
        }

        $insert = RedPromo::insert([
            'promo_name' => trim($request->promo_name),
            'photo' => $promo_img,
            'ar_model' => $promo_ar,
            'promo_marker' => $promo_marker,
            'start_date' => date("Y-m-d", strtotime(trim($request->start_date))),
            'start_at' => date('H:i:s', strtotime($start_time)),
            'start_local' => date('H:i:s', strtotime($get_start_at)),
            'st_date_server' => date('Y-m-d', strtotime($st_ser_date)),
            'length' => trim($request->promo_lenght),
            'end_at' => date('H:i:s', strtotime($end_time)),
            'end_local' => date('H:i:s', strtotime($get_end_at)),
            'latitude' => trim($request->promo_lat),
            'longitude' => trim($request->promo_lng),
            'created_at' => date('Y-m-d'),
            'is_pre_launch' => $is_pre_launch,
            'country_short' => trim($request->promo_country),
            'store_address' => $request->store_address,
            'description' => $request->promo_description
        ]);

        if($insert) {
            return redirect('admin/red_promos/add_coupons')->with(['success' => 'Red Friday Promo Created successfully']);
        }
        else {
            return back()->with(['error' => 'Unable to Create Red Friday Promo']);
        }



    }

    public function addCouponView() {
        $view = view('admin.promos.add_red_coupons');
        $view->title = "Add or Remove Coupons";
        $view->red_promos = RedPromo::get();

        return $view;
    }

    public function getStoreForPromo($id) {
        // get promo details
        $promo = RedPromo::where(['promo_id' => $id])->get();
        // promo details
        $lat = $promo[0]->latitude;
        $lng = $promo[0]->longitude;
        // max radius
        $radius = 1;

        $out_stores = [];

        // get all stores
        $stores = Store::where(['status' => 1])->get();

        if(sizeof($stores) > 0) {
            foreach($stores as $store) {
                // store details
                $t_lat = $store->latitude;
                $t_lng = $store->longitude;

                // calculate distance
                $t_dist = (((acos(sin(($lat*pi()/180)) * sin(($t_lat*pi()/180))
                            + cos(($lat*pi()/180)) * cos(($t_lat*pi()/180))
                            * cos((($lng - $t_lng)*pi()/180))))
                        * 180/pi())*60*1.1515*1.609344);

                if($radius >= $t_dist) {
                    $out_stores[] = ['store_id' => $store->place_id, 'store_name' => $store->contact_name];
                }

            }
        }

        // get coupons for this promo
        $coupons = RedCoupon::join('coupons','coupons.coupon_id','=','red_coupons.coupon_id')
            ->where(['red_coupons.promo_id' => $id])->get();

        return ['stores' => $out_stores, 'coupons' => $coupons ];

    }

    public function getCouponsFromStore($p_id, $s_id) {

        $promo_id = (int)$p_id;
        $store_id = (int)$s_id;
        // output array
        $out_coupons = [];

        // get normal promos for this store
        $promos = PromoLocations::where(['store_id' => $store_id] )->select('promo_id')->get();

        foreach ($promos as $promo) {
            // promo details
            $t_promo_id = $promo->promo_id;

            // get coupons
            $coupons = Coupon::where(['promo_id' => $t_promo_id])->get();

            foreach ($coupons as $coupon) {
                $t_coupon_id =$coupon->coupon_id;
                // check if this from has added to this promo
                $check_coupon = RedCoupon::where(['promo_id' => $promo_id, 'coupon_id' => $t_coupon_id, 'place_id' => $store_id])->count();

                if($check_coupon == 0) {
                    $out_coupons[] = $coupon;
                }


            }

        }


        return $out_coupons;
    }

    public function add_coupon_to_promo($p_id, $st_id, $cp_id) {
        $promo_id = (int)$p_id;
        $store_id = (int)$st_id;
        $coupon_id = (int)$cp_id;

        // insert to database
        $insert = RedCoupon::insert([
            'promo_id' => $promo_id,
            'coupon_id' => $coupon_id,
            'place_id' => $store_id
        ]);

        $update = RedPromo::where('promo_id', $promo_id)->update(['status' => 1,'used' => 1]);

        if($insert){
            // get coupon details
            $coupon = Coupon::where(['coupon_id' => $coupon_id])->get();

            return (['status' => 1, 'coupon' => $coupon]);
        }
        else {
            return (['status' => 0]);
        }
    }

    public function remove_coupon_from_promo($p_id, $cp_id){
        $promo_id = (int)$p_id;
        $coupon_id = (int)$cp_id;

        $delete = RedCoupon::where(['promo_id' => $promo_id, 'coupon_id' => $coupon_id])->delete();

        if($delete) {
            // get coupon details
            $coupon = Coupon::where(['coupon_id' => $coupon_id])->get();

            return (['status' => 1, 'coupon' => $coupon]);
        }
        else {
            return (['status' => 0]);
        }
    }

    public function pause_promo($promo_id){
        // pause promo
        $pause = RedPromo::where('promo_id', $promo_id)->update(['status' => 0]);

        if($pause) {
            // get promo details
            $promo = RedPromo::where('promo_id',$promo_id)->get();

            return (['status' => 1 , 'promo' => $promo]);
        }
        else {
            return (['status' => 0]);
        }
    }

    public function activate_promo($promo_id) {
        // pause promo
        $pause = RedPromo::where('promo_id', $promo_id)->update(['status' => 1]);

        if($pause) {
            // get promo details
            $promo = RedPromo::where('promo_id',$promo_id)->get();

            return (['status' => 1 , 'promo' => $promo]);
        }
        else {
            return (['status' => 0]);
        }
    }

    // give away store
    public function gw_store() {
        $view = view('admin.give_away.give_away_store');

        $view->title = "Create A Give Away Store";
        $view->categories = [];
        return $view;
    }

    // give away promos
    public function gw_promos() {
        $view = view('admin.give_away.give_away_promo');

        $view->title = "Create Give Away Promo";

        return $view;
    }

    // give away coupons
    public function gw_coupon() {
        $view = view('admin.give_away.give_away_coupon');

        $view->title = "Create Give Away Coupons";
        $view->red_promos = RedPromo::where(['status' => 1])->get();

        return $view;
    }

    public function gw_coupon_list() {
        $view = view('admin.give_away.give_away_list');

        $view->title = "Give Away Coupon List";

        return $view;
    }

    public function gw_coupon_create(Request $request){

        // upload images
        // validate
        $this->validate($request, [
            'coupon_photo' => 'required|image|mimes:jpeg,png,jpg',
            'coupon_ar' => 'required|image|mimes:peg,png,jpg',
        ]);


        $coupon_image = '';
        $coupon_ar = '';
        $coupon_marker = '';
        $random = rand(0, 1000000);
        // upload coupon img
        if($request->hasFile('coupon_photo')) {

            $file = $request->file('coupon_photo');
            $file_extention = $file->getClientOriginalExtension();

            $file_name = 'c'.date('Ymdhis').$random.".".$file_extention;

            //Move Uploaded File
            $coupon_img_path = 'resources/assets/coupons/full/';
            $file->move($coupon_img_path,$file_name);

            $coupon_image = $file_name;
        }

        // get coupon ar image
        if($request->hasFile('coupon_ar')) {

            $ar_img = $request->file('coupon_ar');
            $ar_extention = $ar_img->getClientOriginalExtension();

            $ar_name = 'ar'.date('Ymdhis').$random.".".$ar_extention;

            //Move Uploaded File
            $coupon_ar_path = 'resources/assets/media/';
            $ar_img->move($coupon_ar_path,$ar_name);

            // resize ar
            $star_img = new Image($coupon_ar_path.$ar_name);
            $star_img->resize(300,300);
            $star_img->save($coupon_ar_path.$ar_name,IMAGETYPE_PNG);

            $coupon_ar = $ar_name;

            // create store marker
            // create marker
            $marker_name = 'marker' . time().$random . '.png';
            $img_1 = new Image($coupon_ar_path.$ar_name);
            $img_1->scale(60);
            $img_2 = new Image('resources/assets/custom/images/marker.png');
            $img_2->merge($img_1,170,60);
            $img_2->resize(300,300);
            $img_2->save($coupon_ar_path.$marker_name,IMAGETYPE_PNG);

            $coupon_marker = $marker_name;
        }

        // create coupon
        $inst = Coupon::insert([
            'coupon_title' => trim($request->get('coupon_name')),
            'estimated_value' => trim($request->get('coupon_value')),
            'coupon_availabilty' => trim($request->get('availability')),
            'terms_conditions' => trim($request->get('coupon_details')),
            'coupon_information' => trim($request->get('coupon_info')),
            'promo_id' => 0,
            'user_id' => Auth::id(),
            'coupon_photo' => $coupon_image,
            'coupon_model' => $coupon_ar,
            'coupon_marker' => $coupon_marker,
            'is_loyalty' => 0,
            'loyalty_count' => 0,
            'coupon_level' => 1,
            'add_date' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'status' => 2
        ]);

        if($inst) {
            return back()->with(['success' => 'Coupon created successfully']);
        } else {
            return back()->with(['error' => 'Coupons failed to create']);
        }


    }

}
