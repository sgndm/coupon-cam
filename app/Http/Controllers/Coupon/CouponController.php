<?php

namespace App\Http\Controllers\Coupon;

use Illuminate\Http\Request;
use App\User;
use App\Promo;
use App\Coupon;
// use Image;
use App\Http\Requests\CouponRequest;
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

class CouponController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index($id) {
        $view = view('admin.coupons.coupon_list');
        $view->promo = Promo::where("promo_id",$id)->first();
        $view->title = 'List of coupons under '.$view->promo->name;
//        $view->coupons = Coupon::join('promos','coupons.promo_id','=','promos.promo_id')
//                            ->join('users','coupons.user_id','=','users.id')
//                            ->select('coupons.*','promos.promo_name as promo')
//                            ->where(['coupons.promo_id' => $id])
//                            ->get();

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

    public function indexcompany($id) {
        $view = view('admin.coupons.coupon_list');
        $view->company = User::find($id);
        $view->title = 'List of coupons under company - '.$view->company->name;
        $view->coupons = Coupon::join('promos','coupons.promo_id','=','promos.promo_id')
                            ->join('users','coupons.user_id','=','users.id')
                            ->select('coupons.*','promos.promo_name as promo')
                            ->where(['coupons.user_id' => $id])->get();
        return $view;
    }

    public function allcoupons() {
        $view = view('admin.coupons.coupon_list_all');
        $view->title = 'List of coupons';
//        $view->coupons = Coupon::join('promos','coupons.promo_id','=','promos.promo_id')
//                            ->join('users','coupons.user_id','=','users.id')
//                            ->select('coupons.*','promos.promo_name as promo')
//                            ->where(['coupons.status' => '1'])
//                            ->get();

        $view->coupons = Coupon::join('promo_locations', 'promo_locations.promo_id','=','coupons.promo_id')
            ->join('store_user', 'store_user.place_id','=','promo_locations.store_id')
            ->select('coupons.*')
            ->distinct()
            ->where(['promo_locations.status' => 1])
            ->orderBy('coupons.coupon_level', 'ASC')
            ->orderBy('coupons.updated_at', 'DECS')
            ->get();

        return $view;
    }

    public function create() {
        $view = view('admin.coupons.coupon_single');
        $view->title = 'New coupon';
        $view->users   = User::where(['active' => '1', 'usertype' => '0'])->select(['id','name'])->get();
        $view->promos   = Promo::where(['status' => '3'])->select(['promo_id','promo_name'])->get();
        return $view;
    }

    public function save(CouponRequest $request) {

        for($n = 1; $n <= 4; $n++){
           $x = new Coupon();
           $x->coupon_title     = trim($request->get('coupon_name_'.$n));
           $x->estimated_value = trim($request->get('estimated_value_'.$n));
           $x->coupon_availabilty    = trim($request->get('availablity_'.$n));
           $x->terms_conditions = $request->get('term_condition_'.$n);
	   $x->coupon_information = $request->get('dterm_condition_'.$n);
           //$x->start_at = $request->promo_name;
           if($request->get('expiery_date_'.$n) == 'Unlimited' || $request->get('expiery_date_'.$n) == ''){
                $x->expire_date   = '';
           }else{
                $x->expire_date   = date("Y-m-d H:i:s", strtotime($request->get('expiery_date_'.$n)));
           }

           $x->promo_id = $request->get('promo_name');

           $x->user_id  =  $request->get('company_name');

           if($request->hasFile('photo_'.$n)) {
                $image = $request->file('photo_'.$n);
                $filename = time() . '.' . $image->getClientOriginalExtension();
                if (!file_exists('resources/assets/coupons/full')) {
                    mkdir('resources/assets/coupons/full', 0777, true);
                }
                $path = 'resources/assets/coupons/full/' . $filename;
                Image::make($image->getRealPath())->resize(800, 800, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path);
                $x->coupon_photo = $filename;

            }



            $x->coupon_model = $request->get('3d_photo_'.$n);

        if(!empty($request->get('image_data_'.$n))) {
            if (!file_exists('resources/assets/coupons')) {
                mkdir('resources/assets/coupons', 0777, true);
            }
          $destinationPath = 'resources/assets/coupons/';

          $file = str_replace('data:image/png;base64,', '', $request->get('image_data_'.$n));
          $img = str_replace(' ', '+', $file);
          $data = base64_decode($img);
          $filename = date('ymdhis').rand(11111,9999999). '_croppedImage' . ".png";
          $file = $destinationPath . $filename;
          file_put_contents($file, $data);
          $x->photo = $filename;

        }

            $x->save();
        }

        Promo::where("promo_id",$request->get('promo_name'))->update(['used' => '1']);

        return redirect('admin/coupons/promo/'.$request->get('promo_name'))->with(['success' => 'Coupon Created successfully']);
    }

    public function edit($id) {

		$count = Coupon::where("promo_id",$id)->count();
		if($count < 4){
			return redirect('home')->with(['error' => 'All coupons are not being created by the user !!']);;
		}

        \App\Notifications::where([['msgfrom','coupon'],['recordid',$id]])->update(['active' => '0']);
        $view = view('admin.coupons.coupon_edit');
        $view->title = 'Edit coupon';
        $view->promoe = Promo::where(['status' => '1'])->select(['promo_id as id','user_id','promo_name as name'])->get();
        $view->users   = User::where(['active' => '1', 'usertype' => '1'])->select(['id','name'])->get();
        //$view->promos   = Promo::where(['active' => '1'])->select(['id','name'])->get();
        $view->coupons  = Coupon::where(['status'=>'1','promo_id'=>$id])->get();
        return $view;
    }

    public function update(CouponRequest $request) {
        for($n = 1; $n <= 4; $n++){

            $mm = Coupon::where("coupon_id",$request->get('coupon_id_'.$n))->first();
           $fullimage = $mm->coupon_photo;
           $photo = $mm->photo;
           $exp = $mm->expire_date;

           if($request->hasFile('photo_'.$n)) {
                $image = $request->file('photo_'.$n);
                $filename = time() . '.' . $image->getClientOriginalExtension();
                if (!file_exists('resources/assets/coupons/full')) {
                    mkdir('resources/assets/coupons/full', 0777, true);
                }
                $path = 'resources/assets/coupons/full/' . $filename;
                /* if(file_exists('resources/assets/' .$x->logofile)){
                  unlink('resources/assets/'.$x->logofile);
                  } */

                Image::make($image->getRealPath())->resize(800, 800, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path);
                $fullimage = $filename;
            }




                if(!empty($request->get('image_data_'.$n))) {
                    if (!file_exists('resources/assets/coupons')) {
                        mkdir('resources/assets/coupons', 0777, true);
                    }
                  $destinationPath = 'resources/assets/coupons/';

                  $file = str_replace('data:image/png;base64,', '', $request->get('image_data_'.$n));
                  $img = str_replace(' ', '+', $file);
                  $data = base64_decode($img);
                  $filename = date('ymdhis').rand(11111,9999999). '_croppedImage' . ".png";
                  $file = $destinationPath . $filename;
                  $success = file_put_contents($file, $data);
                  $photo = $filename;
                }

           if($request->get('expiery_date_'.$n) == 'Unlimited' || $request->get('expiery_date_'.$n) == ''){
                $exp = '';
           }else{
                $exp = date("Y-m-d H:i:s", strtotime($request->get('expiery_date_'.$n)));
           }

           Coupon::where("coupon_id",$request->get('coupon_id_'.$n))->update([
           "coupon_title" => trim($request->get('coupon_name_'.$n)),
           "estimated_value" => trim($request->get('estimated_value_'.$n)),
           "coupon_availabilty" => trim($request->get('availablity_'.$n)),
           "terms_conditions" => $request->get('term_condition_'.$n),
	   "coupon_information" => $request->get('dterm_condition_'.$n),

           "promo_id" => $request->get('promo_name'),
           //"store_id" => Promo::find($request->get('promo_name'))->store_id,
           "user_id" => $request->get('company_name'),
           "coupon_photo" => $fullimage,
           "expire_date"  => $exp,
           "coupon_model" => $request->get('3d_photo_'.$n),
           "photo" => $photo
          ]);
        }
         Promo::where("promo_id",$request->get('promo_name'))->update(['used' => '1']);

        return redirect('admin/coupons/promo/'.$request->get('promo_name'))->with(['success' => 'Coupon Updated successfully']);
    }

    public function delete($id) {
        $x = Coupon::where("coupon_id",$id)->update(["status" => '0']);
        if($x){
            return redirect('admin/coupons')->with(['success' => 'Coupon Trashed successfully']);
        }  else {
            return back()->with(['error' => 'Promo failed to trashed']);
        }
    }

    public function restore($id) {
        $x = Coupon::where("coupon_id",$id)->update(["status" => '1']);
        if($x){
            return redirect('admin/coupons/trash')->with(['success' => 'Coupon Restored successfully']);
        }  else {
            return back()->with(['error' => 'User failed to restore']);
        }
    }
    public function trash() {
        $view = view('admin.coupons.coupon_trash');
        $view->title = 'Trash';
        $view->promos = Promo::where('status','0')->get();
        return $view;
    }

    public function clear($id) {
        // Will add later
    }

    public function promosbyuser($company){
        $promos = Promo::where(['user_id' => $company])->select('promo_id','promo_name')->get();
        $html = '<option value="">Select Promo</option>';
        foreach ($promos as $key => $promo) {
            $html .= '<option value="'.$promo->promo_id.'">'.$promo->promo_name.'</option>';
        }
        return $html;
    }

    public function singlecoupon($id) {
        $view = view('admin.coupons.coupon_admin_edit');
        $view->title = 'Edit coupon';
        $view->coupons  = Coupon::where(['id' => $id,'active' => '1'])->first();
        return $view;
    }

    public function singleupdate(CouponRequest $request) {

           $x = Coupon::find($request->coupon_id_1);
           $x->name     = trim($request->coupon_name_1);
           $x->availability    = trim($request->get('availablity_1'));
           $x->term_condition = $request->term_condition_1;
           //$x->start_at = $request->promo_name;
           if($request->get('expiery_date_1') == 'Unlimited' || $request->get('expiery_date_1') == ''){
                $x->end_at   = '';
           }else{
                $x->end_at   = date("Y-m-d H:i:s", strtotime($request->get('expiery_date_1')));
           }

           if($request->hasFile('photo_1')) {
                $image = $request->file('photo_1');
                $filename = time() . '.' . $image->getClientOriginalExtension();
                if (!file_exists('resources/assets/coupons')) {
                    mkdir('resources/assets/coupons', 0777, true);
                }
                $path = 'resources/assets/coupons/' . $filename;
                /* if(file_exists('resources/assets/' .$x->logofile)){
                  unlink('resources/assets/'.$x->logofile);
                  } */

                Image::make($image->getRealPath())->resize(800, 800, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path);
                $x->full_photo = $filename;


            }else{
                    if(!empty($request->get('image_data_1'))) {
                        if (!file_exists('resources/assets/coupons')) {
                            mkdir('resources/assets/coupons', 0777, true);
                        }
                      $destinationPath = 'resources/assets/coupons/';

                      $file = str_replace('data:image/png;base64,', '', $request->get('image_data_1'));
                      $img = str_replace(' ', '+', $file);
                      $data = base64_decode($img);
                      $filename = date('ymdhis').rand(11111,9999999). '_croppedImage' . ".png";
                      $file = $destinationPath . $filename;
                      file_put_contents($file, $data);
                      $x->photo = $filename;

                    }
            }

            if($request->hasFile('3d_photo_1')) {
                $file = $request->file('3d_photo_1');
                $filename = $time . '.' . $file->getClientOriginalExtension();
                if(!file_exists('resources/assets/3d_image')) {
                    mkdir('resources/assets/3d_image', 0777, true);
                }
                $path = 'resources/assets/3d_image/';
                $file->move($path, $filename);
                $x->photo_obj = $filename;
            }

        $x->save();
        return redirect('admin/coupons/'.$request->coupon_id_1)->with(['success' => 'Coupon Updated successfully']);
    }

    public function get_promos($id) {
      $get_promos = Promo::where(['user_id' => $id, 'status' => 3, 'used' => '0'])->get();

      return $get_promos;
    }

    public function single_create(Request $request) {
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
         'promo_id' => trim($request->get('promo_name')),
//         'user_id' => trim($request->get('company_name')),
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

       $promo_id = trim($request->get('promo_name'));

       if($inst) {

         // update promo
         $id = Promo::where("promo_id",$promo_id)->update(['used' => '1', 'status' => 3,"updated_at" => date('Y-m-d H:i:s')]);

         return back()->with(['success' => 'Coupon created successfully']);
       } else {
         return back()->with(['error' => 'Coupons failed to create']);
       }
    }

}
