<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Store;
use App\StoreUser;
use App\User;
use App\StoreCategory;
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

class StoreController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index() {
        $view = view('admin.stores.store_list');
        $view->title = 'List of stores';
//        $view->stores = Store::join('users','users.id','=','places.user_id')
//                        ->where(['places.status' => '1','users.active' => '1'])
//                        ->select('places.*','users.name as company')
//                        ->get();

        $view->stores = Store::join('store_user', 'store_user.place_id', '=', 'places.place_id')
            ->join('users', 'users.id','=','store_user.user_id')
            ->select('users.name as company', 'places.*')
            ->where(['users.active' => '1', 'places.status' => '1'])
            ->get();

        return $view;
    }

    public function closed() {
        $view = view('admin.stores.store_list_closed');
        $view->title = 'List of closed stores';
//        $view->stores = Store::join('users','users.id','=','places.user_id')
//                        ->where(['places.status' => '0','users.active' => '1'])
//                        ->select('places.*','users.name as company')
//                        ->get();
        $view->stores = Store::join('store_user', 'store_user.place_id', '=', 'places.place_id')
            ->join('users', 'users.id','=','store_user.user_id')
            ->select('users.name as company', 'places.*')
            ->where(['users.active' => '1', 'places.status' => '0'])
            ->get();
        return $view;
    }

    public function create() {
        $view = view('admin.stores.store_create');
        $view->title = 'New store';
        $view->users   = User::where(['active' => '1', 'usertype' => '0'])->select(['id','name'])->get();
        $view->categories = StoreCategory::where(['status' => '1'])->get();
        return $view;
    }

    public function save(StoreRequest $request) {
       /* echo "<pre>";
        print_r($_POST);
        exit();
        */

        // upload images
        // validate
        $this->validate($request, [
            'store_image' => 'required|image|mimes:jpeg,png,jpg',
            'store_ar' => 'required|image|mimes:jpeg,png,jpg',
        ]);


        $store_image = '';
        $store_ar = '';
        $store_marker = '';
        $random = rand(0, 1000000);
        // get store image
        if($request->hasFile('store_image')) {

            $file = $request->file('store_image');
            $file_extention = $file->getClientOriginalExtension();

            $file_name = 's'.date('Ymdhis').$random.".".$file_extention;

            //Move Uploaded File
            $store_image_path = 'resources/assets/stores/store_photo/';
            $file->move($store_image_path,$file_name);

            $store_image = $file_name;
        }

        // get store ar image
        if($request->hasFile('store_ar')) {

            $ar_img = $request->file('store_ar');
            $ar_extention = $ar_img->getClientOriginalExtension();

            $ar_name = 's'.date('Ymdhis').$random.".".$ar_extention;

            //Move Uploaded File
            $store_ar_path = 'resources/assets/stores/store_ar/';
            $ar_img->move($store_ar_path,$ar_name);

            // resize ar
            $star_img = new Image($store_ar_path.$ar_name);
            $star_img->resize(300,300);
            $star_img->save($store_ar_path.$ar_name,IMAGETYPE_PNG);

            $store_ar = $ar_name;

            // create marker
            $marker_name = 'marker' . time().$random . '.png';
            $img_1 = new Image($store_ar_path.$ar_name);
            $img_1->scale(60);
            $img_2 = new Image('resources/assets/custom/images/marker.png');
            $img_2->merge($img_1,170,60);
            $img_2->resize(300,300);
            $img_2->save($store_ar_path.$marker_name,IMAGETYPE_PNG);

            $store_marker = $marker_name;
        }


        $store_id = Store::insertGetId([
            'under_category' => json_encode($request->category),
            'contact_name' => trim($request->name),
            'street_number' => trim($request->street_number),
            'street_address' => ($request->address != '')?trim($request->address):trim($request->address_address),
            'address' => trim($request->street_number)." ".trim($request->address),
            'city' => trim($request->city),
            'postal_code' => trim($request->zip_code),
            'state' => trim($request->state),
            'country' => trim($request->country),
            'country_short' => trim($request->country_short),
            'store_description' => trim($request->store_description),
            'latitude' => trim($request->ar_model_lat),
            'longitude' => trim($request->ar_model_long),
            'qr_code' => trim($request->promo_qr_code),
            'qr_image' => trim($request->promo_qr_image),
            'is_give_away' => 1,
            'store_photo' => $store_image,
            'store_ar' => $store_ar,
            'store_marker' => $store_marker,
            'status' => 1
        ]);

        if($store_id){

            // add to user store table
            $istStU = StoreUser::insert([
                'place_id' => $store_id,
                'user_id' => $request->userid
            ]);

            return redirect('admin/stores')->with(['success' => 'Store Created successfully']);
        }  else {
            return back()->with(['error' => 'Store failed to create']);
        }
    }

    public function edit($id) {

        \App\Notifications::where([['msgfrom','shop'],['recordid',$id]])->update(['active' => '0']);
        $view = view('admin.stores.store_edit');
        $view->title = 'Edit store';
        $view->store = Store::where("place_id",$id)->first();
        $view->users   = User::where(['active' => '1', 'usertype' => '1'])->select(['id','name'])->get();
        $view->categories = StoreCategory::where(['status' => '1'])->get();
        return $view;
    }

    public function update(StoreRequest $request) {

        $id = Store::where('place_id', $request->formid)
            ->update([
               'under_category' => json_encode($request->category),
               'contact_name' => trim($request->name),
               'email' => trim($request->email),
               'phone_number' => trim($request->contact),
               'street_number' =>  trim($request->street_number),
               'street_address' => ($request->address != '')?trim($request->address):trim($request->address_address),
               'city' => trim($request->city),
               'postal_code' => trim($request->zip_code),
               'state' => trim($request->state),
               'country' => trim($request->country),
               'address' => trim($request->street_number).' '.trim($request->address),
               'latitude' => trim($request->ar_model_lat),
               'longitude' => trim($request->ar_model_long),
               'updated_at' => date('Y-m-d h:i:s'),
               'status' => $request->active
        ]);

        if($id){
            return redirect('admin/stores')->with(['success' => 'Store Updated successfully']);
        }  else {
            return back()->with(['error' => 'Store failed to create']);
        }
    }

    public function delete($id) {
        $x = Store::where(['id' => $id])->update(['status' => '0']);

        if($x){
            return redirect('admin/stores')->with(['success' => 'Store Closed successfully']);
        }  else {
            return back()->with(['error' => 'Store failed to Closed']);
        }
    }

    public function restore($id) {
        $x = Store::where(['id' => $id])->update(['status' => '1']);

        if($x){
            return redirect('admin/stores/trash')->with(['success' => 'Store Restored successfully']);
        }  else {
            return back()->with(['error' => 'User failed to restore']);
        }
    }
    public function trash() {
        $view = view('admin.stores.store_trash');
        $view->title = 'Closed';
        $view->stores = Store::where('status','0')->get();
        return $view;
    }

    public function clear($id) {
        // Will add later
    }

    public function filter(Request $request) {
        if($request->name != '' && $request->usertype == 3): // for all users by specific email or name
        elseif ($request->name != '' && $request->usrtype != 3): // for specific usertype by specific email or name
        elseif ($request->name == '' && $request->usrtype != 3):  // for specific users by unspecified email or name
        elseif ($request->name == '' && $request->usrtype != 3):  // for specific users by unspecified email or name
        endif;
    }
}
