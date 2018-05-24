<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\User;
use App\Mail\ContentPosted;
use App\Mail\UserAcceptance;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('admin');
    }
    
    public function index() {
        $view = view('admin.users.user_list');
        $view->title = 'List of users';
        $view->users = User::where('active','1')->get();
        return $view;       
    }
    
    public function create() {
        $view = view('admin.users.user_create');
        $view->title = 'New user';
        return $view;
    }
    
    public function save(UserRequest $request) {
        $x = new User();
        $x->name = trim($request->name);
        $x->email = trim($request->email);
        $x->address = (trim($request->address) != "")?$request->address:$request->address_address;
        
        $x->city = trim($request->city);
        $x->zip_code = trim($request->zip_code);
        $x->state = trim($request->state);
        $x->country = trim($request->country);
        
        $x->contact = trim($request->contact_details);
        $x->usertype = $request->usertype;
        $x->password = bcrypt($request->password);
        $x->xpass   =  $request->password;
        if($x->save()){
        
         /*   $subject = 'New Account Created at Coupon Go';
           // $msg1 = 'You have get this email because '.Auth::user()->name.' has updated an store - <strong>'.$request->name.'</strong>';
           // $url1 = 'admin/stores/edit/'.$x->id;
            
            $msg2 = 'You have get this email because your account has been succesfully created at Coupon Go.<br/>';
            $msg2 .= 'Your Account details are:<br/> Email id : <strong> '.$request->email.'</strong><br/> Password : <strong> '.$request->password.'</strong>';
            $url2 = url('/login');
            
           // Mail::to(env('MAIL_USERNAME'))->send(new ContentPosted($msg1,$url1,$subject));
            Mail::to($request->email)->send(new ContentPosted($msg2,$url2,$subject));
            */
            return redirect('admin/users')->with(['success' => 'User Created successfully']);
        }  else {
            return back()->with(['error' => 'User failed to create']);
        }
    }
    
    public function edit($id) {
        $view = view('admin.users.user_edit');
        $view->title = 'Edit user';
        $view->user = User::find($id);
        return $view;
    }
    
    public function update(UserRequest $request) {
        $x = User::find($request->formid);
        $x->name = trim($request->name);
        $x->email = trim($request->email);
        $x->address = (trim($request->address) != "")?$request->address:$request->address_address;
        
        
        $x->city = trim($request->city);
        $x->zip_code = trim($request->zip_code);
        $x->state = trim($request->state);
        $x->country = trim($request->country);
        
        
        $x->contact = trim($request->contact_details);
        $x->usertype = $request->usertype;
        $x->password = bcrypt($request->password);
        $x->xpass   =  $request->password;
        if($x->save()){
        
          /* $subject = 'Your Account has been updated at Coupon Go';
           // $msg1 = 'You have get this email because '.Auth::user()->name.' has updated an store - <strong>'.$request->name.'</strong>';
           // $url1 = 'admin/stores/edit/'.$x->id;
            
            $msg2 = 'You have get this email because your account has been succesfully updated at Coupon Go.<br/>';
            $msg2 .= 'Your Account details are:<br/> Email id : <strong> '.$request->email.'</strong><br/> Password : <strong> '.$request->password.'</strong>';
            $url2 = url('/login');
        	Mail::to($request->email)->send(new ContentPosted($msg2,$url2,$subject));
        	//Mail::to($x->email)->send(new UserAcceptance);
        	*/
            return redirect('admin/users')->with(['success' => 'User Updated successfully']);
        }  else {
            return back()->with(['error' => 'User failed to create']);
        }
    }
    
    public function delete($id) {
        $x = User::find($id);
        $x->active   =  '0';
        if($x->save()){
            return redirect('admin/users')->with(['success' => 'User Trashed successfully']);
        }  else {
            return back()->with(['error' => 'User failed to trashed']);
        }
    }
    
    public function restore($id) {
        $x = User::find($id);
        $x->active   =  '1';
        if($x->save()){
            return redirect('admin/users/trash')->with(['success' => 'User Restored successfully']);
        }  else {
            return back()->with(['error' => 'User failed to restore']);
        }
    }
    public function trash() {
        $view = view('admin.users.user_trash');
        $view->title = 'Trash';
        $view->users = User::where('active','0')->get();
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
