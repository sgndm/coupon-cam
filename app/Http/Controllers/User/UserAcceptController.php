<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Auth;
use Validator;
use App\User;
use App\Mail\UserAcceptance;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests;
use App\Http\Requests\UserPanelRequest;
use App\Http\Controllers\Controller;

class UserAcceptController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    
    public function accept() {
        $view = view('admin.users_panel.accept');
        $view->title = 'Terms & Conditions';
        $view->heading = 'Terms & Conditions';
        $view->col = 1;
        return $view;                
    }
    
    public function accepted(UserPanelRequest $request) {

        $x = User::find(Auth::id());
        $x->name = trim($request->name);
        $x->first_name = trim($request->first_name);
        $x->last_name = trim($request->last_name);
        $x->accepted = '1';
        if($x->save()){
            //Mail::to($x->email)->send(new UserAcceptance);
//            return redirect('settings');
            return redirect('user/stores');
        }  else {
            return back()->with(['error' => 'Sorry failed to Accept']);
        }
    }
}
