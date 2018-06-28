<?php

namespace App\Http\Controllers\Store;

use App\BusinessTypes;
use App\PromoLocations;
use Illuminate\Http\Request;
use Auth;
use App\Mail\ContentPosted;
use Illuminate\Support\Facades\Mail;
use App\Store;
use App\StoreUser;
use App\StoreCategory;
use App\User;
use App\UserTable;
use App\Notifications;
use App\Http\Requests\StoreRequest;
use App\Http\Requests;
use App\Http\Controllers\Controller;

// image manipulations
use Treinetic\ImageArtist\lib\Overlays\Overlay;
use Treinetic\ImageArtist\lib\Text\Color;
use Treinetic\ImageArtist\lib\Shapes\PolygonShape;
use Treinetic\ImageArtist\lib\Commons\Node;
use Treinetic\ImageArtist\lib\Image;
use Treinetic\ImageArtist\lib\Shapes\Square;

class UserStoreController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }


    public function index() {
        $view = view('user.stores.store');
        $view->title = 'CouponCam::Stores';
        $view->categories = StoreCategory::where(['status' => '1'])->get();
        $view->business_types = BusinessTypes::get();

        $openStores = Store::join('store_user', 'store_user.place_id', '=', 'places.place_id')
            ->where(['store_user.user_id' => Auth::id(), 'places.status' => 1])
            ->select('places.*')
            ->distinct()
            ->orderBY('places.updated_at', 'DESC')
            ->get();

            $view->openStores = $openStores;

        $has_stores = 0;

        if(sizeof($openStores) > 0) {
            $has_stores = 1;
        }

        $view->has_stores = $has_stores;

        $view->closedStores = Store::join('store_user', 'store_user.place_id', '=', 'places.place_id')
            ->where(['store_user.user_id' => Auth::id(), 'places.status' => 0])
            ->select('places.*')
            ->distinct()
            ->orderBY('places.updated_at', 'DESC')
            ->get();

        $get_user = UserTable::where(['id' => Auth::id()])->select('is_member')->get();

        $view->is_member = $get_user[0]->is_member;

        return $view;
    }

    // get active store
    public function get_active_stores() {
        $store_details = Store::join('store_user', 'store_user.place_id', '=', 'places.place_id')
            ->select('places.*')
            ->distinct()
            ->where(['store_user.user_id' => Auth::id(), 'places.status' => 1])
            ->orderBY('places.updated_at', 'DESC')
            ->get();

        return($store_details);
    }

    // get cloased stores
    public function get_closed_stores() {
        $store_details = Store::join('store_user', 'store_user.place_id', '=', 'places.place_id')
            ->where(['store_user.user_id' => Auth::id(), 'places.status' => 0])
            ->orderBY('places.updated_at', 'DESC')
            ->get();

        return($store_details);
    }

    // Create store
    public function create_store(StoreRequest $request) {

        // validate
        // $this->validate($request, [
        //     'store_image' => 'required|image|mimes:jpeg,png,jpg',
        //     'store_ar' => 'required|image|mimes:png',
        // ]);


        $store_image = '';
        $store_ar = '';
        $store_marker = '';
        $random = rand(0, 1000000);
        // get store image
        // if($request->hasFile('store_image')) {

        //     $file = $request->file('store_image');
        //     $file_extention = $file->getClientOriginalExtension();

        //     $file_name = 's'.date('Ymdhis').$random.".".$file_extention;

        //     //Move Uploaded File
        //     $store_image_path = 'resources/assets/stores/store_photo/';
        //     $file->move($store_image_path,$file_name);

        //     $store_image = $file_name;
        // }

        // get store ar image
        // if($request->hasFile('store_ar')) {

        //     $ar_img = $request->file('store_ar');
        //     $ar_extention = $ar_img->getClientOriginalExtension();

        //     $ar_name = 's'.date('Ymdhis').$random.".".$ar_extention;

        //     //Move Uploaded File
        //     $store_ar_path = 'resources/assets/stores/store_ar/';
        //     $ar_img->move($store_ar_path,$ar_name);

        //     // resize ar
        //     $star_img = new Image($store_ar_path.$ar_name);
        //     $star_img->resize(300,300);
        //     $star_img->save($store_ar_path.$ar_name,IMAGETYPE_PNG);

        //     $store_ar = $ar_name;

        //     // create marker
        //     $marker_name = 'marker' . time().$random . '.png';
        //     $img_1 = new Image($store_ar_path.$ar_name);
        //     $img_1->scale(60);
        //     $img_2 = new Image('resources/assets/custom/images/marker.png');
        //     $img_2->merge($img_1,170,60);
        //     $img_2->resize(300,300);
        //     $img_2->save($store_ar_path.$marker_name,IMAGETYPE_PNG);

        //     $store_marker = $marker_name;
        // }

        $is_give_away = 0;

        $store_id = Store::insertGetId([
            'under_category' => json_encode($request->category_1),
            'contact_name' => trim($request->store_name),
            'store_promo' => '',
            'street_number' =>  trim($request->street_num),
            'street_address' => trim($request->street_name),
            'city' => trim($request->city),
            'postal_code' => trim($request->postal_code),
            'state' => trim($request->state),
            'country' => trim($request->country),
            'address' => trim($request->store_address),
            'latitude' => trim($request->store_lat),
            'longitude' => trim($request->store_lng),
            'created_at' => date('Y-m-d h:i:s'),
            'updated_at' => date('Y-m-d h:i:s'),
            'status' => '1',
            'store_photo' => $store_image,
            'store_ar' => $store_ar,
            'store_marker' => $store_marker,
            'country_short' => trim($request->country_short),
            'store_description' => '',
            'is_give_away' => $is_give_away,
            'qr_code' => trim($request->promo_qr_code),
            'qr_image' => trim($request->promo_qr_image)
        ]);

        if($store_id){

            // insert data into store user table
            $inst = StoreUser::insert([
                'place_id' => $store_id,
                'user_id' => Auth::id()
            ]);

            $n = new Notifications();
            $n->recordid = $store_id;
            $n->msgfrom  = 'shop';
            $n->msg      = 'added a store';
            $n->user_id  = Auth::id();
            $n->save();

            $subject = 'New Store Introduced';

            $msg1 = 'You have get this email because '.Auth::user()->name.' has created an store - <strong>'.$request->name.'</strong>';
            $url1 = 'admin/stores/edit/'.$store_id;

            $msg2 = 'This email is to confirm we have received your new store details! - <strong>'.$request->name.'</strong><br/>';
            $msg2 .= 'Now its time to link a promo to your store.<br/>';
            $msg2 .= 'Thanks for using CouponCam!';
            $url2 = 'user/promos';

            //    Mail::to(env('MAIL_USERNAME'))->send(new ContentPosted($msg1,$url1,$subject));
            //    Mail::to(Auth::user()->email)->send(new ContentPosted($msg2,$url2,$subject,'Create A Promo'));

            return redirect('user/promos')->with(['success' => 'Store created successfully, now please create a promo for your store']);
        }  else {
            return back()->with(['error' => 'Store failed to create']);
        }


    }

    // Create store
    public function update_store(StoreRequest $request) {

        if(isset($_POST['close_store'])) {
            $store_id = Store::where('place_id', $request->formid)
                ->update([
                    'status' => 0,
                    'updated_at' => date('Y-m-d h:i:s'),
                ]);

            if($store_id){

                // update promo_locations
                $upd = PromoLocations::where('store_id', $request->formid)
                    ->update(['status' => 0, 'updated_at' => date('Y-m-d H:i:s')]);

                return redirect('user/stores')->with(['success' => 'Store Closed successfully']);
            }  else {
                return back()->with(['error' => 'Store failed to close']);
            }
        }
        else {

            // validate
            // $this->validate($request, [
            //     'store_image' => 'image|mimes:jpeg,png,jpg',
            //     'store_ar' => 'image|mimes:png',
            // ]);


            $store_image = '';
            $store_ar = '';
            $store_marker ='';
            $random = rand(0, 1000000);
            // get store image
            // if($request->hasFile('store_image')) {

            //     $file = $request->file('store_image');
            //     $file_extention = $file->getClientOriginalExtension();

            //     $file_name = date('Ymdhis').$random.".".$file_extention;

            //     //Move Uploaded File
            //     $store_image_path = 'resources/assets/stores/store_photo/';
            //     $file->move($store_image_path,$file_name);

            //     $store_image = $file_name;
            // }
            // else {
            //     $store_image = trim($request->store_image_hidden);
            // }

            // get store ar image
            // if($request->hasFile('store_ar')) {

            //     $ar_img = $request->file('store_ar');
            //     $ar_extention = $ar_img->getClientOriginalExtension();

            //     $ar_name = date('Ymdhis').$random.".".$ar_extention;

            //     //Move Uploaded File
            //     $store_ar_path = 'resources/assets/stores/store_ar/';
            //     $ar_img->move($store_ar_path,$ar_name);

            //     // resize ar
            //     $star_img = new Image($store_ar_path.$ar_name);
            //     $star_img->resize(300,300);
            //     $star_img->save($store_ar_path.$ar_name,IMAGETYPE_PNG);

            //     $store_ar = $ar_name;

            //     // create marker
            //     $marker_name = 'marker' . time().$random . '.png';
            //     $img_1 = new Image($store_ar_path.$ar_name);
            //     $img_1->scale(60);
            //     $img_2 = new Image('resources/assets/custom/images/marker.png');
            //     $img_2->merge($img_1,170,60);
            //     $img_2->resize(300,300);
            //     $img_2->save($store_ar_path.$marker_name,IMAGETYPE_PNG);

            //     $store_marker = $marker_name;

            // }
            // else {
            //     $store_ar = trim($request->store_ar_hidden);
            //     $store_marker = trim($request->store_marker_hidden);
            // }

            $is_give_away = 0;

            $store_id = Store::where('place_id', $request->formid)
                ->update([
                    'under_category' => json_encode($request->category_2),
                    'contact_name' => trim($request->store_name),
                    'store_promo' => '',
                    'street_number' =>  trim($request->street_num),
                    'street_address' => trim($request->street_name),
                    'city' => trim($request->city),
                    'postal_code' => trim($request->postal_code),
                    'state' => trim($request->state),
                    'country' => trim($request->country),
                    'address' => trim($request->street_num).",".trim($request->street_name).",".trim($request->city).",".trim($request->state).",".trim($request->country),
                    'latitude' => trim($request->store_lat),
                    'longitude' => trim($request->store_lng),
                    'created_at' => date('Y-m-d h:i:s'),
                    'updated_at' => date('Y-m-d h:i:s'),
                    'status' => '1',
                    'store_photo' => $store_image,
                    'store_ar' => $store_ar,
                    'store_marker' => $store_marker,
                    'country_short' => trim($request->country_short),
                    'store_description' => '',
                    'is_give_away' => $is_give_away,
                    'qr_code' => trim($request->promo_qr_code),
                    'qr_image' => trim($request->promo_qr_image)
                ]);

            if($store_id){

                return redirect('user/stores')->with(['success' => 'Store Updated successfully']);
            }  else {
                return back()->with(['error' => 'Store failed to update']);
            }

        }




    }

    // Delete oe reopen store
    public function delete_store(StoreRequest $request) {
        if(isset($_POST['delete_store'])) {
            $store_id = Store::where('place_id', $request->formid)
                ->delete();

            if($store_id){
                // delete from promo locations
                $del = PromoLocations::where('store_id', $request->formid)->delete();
                $del2 = StoreUser::where('place_id', $request->formid)->delete();

                return redirect('user/stores')->with(['success' => 'Store Deleted successfully']);
            }  else {
                return back()->with(['error' => 'Store failed to delete']);
            }
        }
        else {
            $store_id = Store::where('place_id', $request->formid)
                ->update([
                    'status' => 1,
                    'updated_at' => date('Y-m-d h:i:s'),
                ]);

            if($store_id){

                $upd = PromoLocations::where('store_id', $request->formid)
                    ->update(['status' => 1, 'updated_at' => date('Y-m-d H:i:s')]);

                return redirect('user/stores')->with(['success' => 'Store Reopened successfully']);
            }  else {
                return back()->with(['error' => 'Store failed to reopen']);
            }
        }
    }

    // get store details by id
    public function get_user_details_by_id($id){

        $response = array('status' => '','details' => '');

        $store_details = Store::where(['place_id' => $id])->get();


        $categoris = $store_details[0]->under_category;

        $remove_char = array("[","\"","]");
        $list = trim(str_replace($remove_char,"",$categoris));
        $categories = explode(",", $list);

        // get business types
        $get_business = BusinessTypes::join('place_categories','place_categories.type_id','=','business_types.id')->where(['place_categories.id' => $categories[0]])->select('business_types.id')->get();




        if(sizeof($store_details) > 0) {
            foreach($store_details as $store) {

                $response['status'] = 1;
                $response['details'] = $store_details;
                $response['categories'] = $categories;
                $response['business'] = $get_business;

            }
        } else {
            // return empty //
            $response['status'] = 0;

        }

        return($response);

    }

    // search store
    public function search_store($input){
//        $stores  = Store::join('users', 'users.id','=','places.user_id')
//            ->select('users.name', 'places.contact_name', 'places.created_at','places.address')
//            ->where('places.contact_name', 'like', '%'.$input.'%')->get();

        $stores = Store::join('store_user', 'store_user.place_id', '=', 'places.place_id')
            ->join('users', 'users.id', '=', 'store_user.user_id')
            ->select('places.*', 'users.name')
            ->where('places.contact_name', 'like', '%'.$input.'%')
            ->get();

        return($stores);
    }

    public function get_category_by_type($type_id) {
        $get_cat = StoreCategory::where(['type_id' => $type_id, 'status' => 1])->get();
        return ($get_cat);
    }

}
