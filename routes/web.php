<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});
Route::get('/home', function () {
    if(\Illuminate\Support\Facades\Auth::user()->usertype == 1){
            return redirect('coupon/quickform');
        }else{
            return redirect('dashboard');
        }
});
Auth::routes();
/*Route::get('/register', function () {
    return redirect('login');
});*/
Route::get('/home', 'HomeController@index');

Route::get('/media', 'HomeController@media');
Route::post('/media/create', 'HomeController@create');
Route::get('/media/delete/{id}', 'HomeController@delete');
Route::post('/media/search', function () {
    return redirect('media/search/'.str_replace(" ","-",$_POST['search']));
});
Route::get('/media/search/{id}', 'HomeController@search');
Route::get('/test', 'HomeController@test');

include_once('paths/users_panel.php');
include_once('paths/users.php');
include_once('paths/stores.php');
include_once('paths/promos.php');
include_once('paths/coupons.php');

include_once('paths/apis.php');
