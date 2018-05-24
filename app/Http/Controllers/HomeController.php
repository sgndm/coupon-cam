<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Media;
// use Image;
use Auth;

use Treinetic\ImageArtist\lib\Overlays\Overlay;
use Treinetic\ImageArtist\lib\Text\Color;
use Treinetic\ImageArtist\lib\Shapes\PolygonShape;
use Treinetic\ImageArtist\lib\Commons\Node;
use Treinetic\ImageArtist\lib\Image;
use Treinetic\ImageArtist\lib\Shapes\Square;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->usertype == 1){
            return redirect('dashboard'); // Redirect to dashboard || earlier was to East Setup || Later check is this first time and redirect to Easy Setup
        }else{
            return redirect('dashboard');
        }
    }


    public function media(){
        $view = view('media');
        $view->title = "Media";
        $view->keyword = "";
        if(Auth::user()->usertype == '0'){
        	$view->images = Media::where("image_private","0")->orderby('id','desc')->paginate(7);
        }elseif(Auth::user()->usertype == '1'){
        	$view->images = Media::where("image_private","0")->orWhere("under_user_id",Auth::id())->orderby('id','desc')->paginate(7);
        }
        return $view;
    }

    public function search($query){
        $query = str_replace("-"," ",$query);
        $view = view('media');
        $view->keyword = $query;
        if(Auth::user()->usertype == '0'){
        	$view->images = Media::where([["image_private","0"],["image_tags","like",'%'.$query.'%']])->orderby('id','desc')->paginate(7);
        }elseif(Auth::user()->usertype == '1'){
        	$view->images = Media::where([["image_private","0"],["image_tags","like","%".$query."%"]])->orWhere("under_user_id",Auth::id())->orderby('id','desc')->paginate(7);
        }
        return $view;
    }

    public function create(Request $request) {
        $x = new Media();
        $x->image_tags = $request->image_name;
        $imgname = "";
        if($request->hasFile('image_thumbnail')) {
            $image = $request->file('image_thumbnail');
            $filename = 'ar'.time() . '_thumbnail.' . $image->getClientOriginalExtension();
            if (!file_exists('resources/assets/media')) {
                mkdir('resources/assets/media', 0777, true);
            }
            $path = 'resources/assets/media/';
            // upload image
            $image->move($path,$filename);
            // resize and save
           $ar_img = new Image($path.$filename);
           $ar_img->resize(300,300);
           $ar_img->save($path.$filename,IMAGETYPE_PNG);

           // create marker
           $marker_name = 'marker' . time() . '.png';
           $img_1 = new Image($path.$filename);
           $img_1->scale(60);
           $img_2 = new Image('resources/assets/custom/images/marker.png');
           $img_2->merge($img_1,170,60);
           $img_2->resize(300,300);
           $img_2->save($path.$marker_name,IMAGETYPE_PNG);

           // name for db
            $x->image_thumbnail = $filename;
            $x->marker = $marker_name;
        }

        // add to db
        $x->image_private = $request->image_private;
        $x->under_user_id = Auth::id();
        if($x->save()){
           return redirect('media');
        }
    }

    public function delete($id){
     	$x = Media::where("id",$id)->delete();
     	if($x){
     	   return back();
     	}
    }

}
