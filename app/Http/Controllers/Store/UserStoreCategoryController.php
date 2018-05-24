<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Store;
use App\User;
use App\StoreCategory;
use App\Http\Requests\StoreRequest;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserStoreCategoryController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    
    public function index() {
        $view = view('user.stores.store_category_create_list');
        $view->title = 'List of stores category';
        $view->categories = StoreCategory::where(['status' => '1'])->get();
        return $view;       
    }
    
    public function closed() {
        $view = view('user.stores.store_category_create_list');
        $view->title = 'List of closed stores';
        $view->categories = StoreCategory::where(['status' => '0'])->get();
        return $view;       
    }
    
    public function create() {
        $view = view('user.stores.store_category_create_list');
        $view->title = 'New category';
        $view->categories = StoreCategory::where(['status' => '1'])->get();
        return $view;
    }
    
    public function save(StoreRequest $request) {
        $x = new StoreCategory();
        $x->category = trim($request->name);
        $x->status  = '1';
        if($x->save()){
            return redirect('user/stores/category/edit/'.$x->id)->with(['success' => 'Store Category Created successfully']);
        }  else {
            return back()->with(['error' => 'Store Category failed to create']);
        }
    }
    
    public function edit($id) {
        $view = view('user.stores.store_category_edit_list');
        $view->title = 'Edit Category';
        $view->storecategory = StoreCategory::find($id);
        $view->categories = StoreCategory::where(['status' => '1'])->get();
        return $view;
    }
    
    public function update(StoreRequest $request) {
        $x = StoreCategory::find($request->formid);
        $x->category = trim($request->name);
        $x->status    =  '1';
        if($x->save()){
            return redirect('user/stores/category/edit/'.$x->id)->with(['success' => 'Store Category Updated successfully']);
        }  else {
            return back()->with(['error' => 'Store category failed to create']);
        }
    }
    
    public function delete($id) {
        $x = StoreCategory::find($id);
        $x->status   =  '0';
        if($x->save()){
            return redirect('user/stores/category')->with(['success' => 'Store Category Trashed successfully']);
        }  else {
            return back()->with(['error' => 'Store Category failed to trashed']);
        }
    }
    
    public function restore($id) {
        $x = StoreCategory::find($id);
        $x->status   =  '1';
        if($x->save()){
            return redirect('user/stores/category/trash')->with(['success' => 'Store Category Restored successfully']);
        }  else {
            return back()->with(['error' => 'User failed to restore']);
        }
    }
    public function trash() {
        $view = view('user.stores.store_trash');
        $view->title = 'Trash';
        $view->stores = StoreCategory::where('active','0')->get();
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
    
    public function new_category() {
        $cats  = StoreCategory::where('category',strip_tags(trim($_REQUEST['new_category'])))->count();
        if($cats == 0){
            $x = new StoreCategory();
            $x->category = strip_tags(trim($_REQUEST['new_category']));
            $x->status  = '1';
            if($x->save()){
                return json_encode($x);
            }
        }else{
            return "0";
        }
    }
}
