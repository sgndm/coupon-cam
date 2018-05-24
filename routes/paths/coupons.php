<?php
Route::get('/admin/coupons', 'Coupon\CouponController@allcoupons');
Route::get('/admin/coupons/promo/{id}', 'Coupon\CouponController@index');
Route::get('/admin/coupons/company/{id}', 'Coupon\CouponController@indexcompany');
Route::get('/admin/coupons/create', 'Coupon\CouponController@create');
Route::post('/admin/coupons/save', 'Coupon\CouponController@save');
Route::get('/admin/coupons/edit/{id}', 'Coupon\CouponController@edit');
Route::post('/admin/coupons/update', 'Coupon\CouponController@update');
Route::get('/admin/coupons/delete/{id}', 'Coupon\CouponController@delete');
Route::get('/admin/coupons/trash', 'Coupon\CouponController@trash');
Route::get('/admin/coupons/restore/{id}', 'Coupon\CouponController@restore');
Route::get('/admin/coupons/clear/{id}', 'Coupon\CouponController@clear');
Route::post('/admin/coupons/filter', 'Coupon\CouponController@filter');
Route::get('/admin/coupons/promos/{company}', 'Coupon\CouponController@promosbyuser');
Route::get('admin/coupons/get_promos/{id}', 'Coupon\CouponController@get_promos');

Route::get('/admin/coupons/{id}', 'Coupon\CouponController@singlecoupon');
Route::post('/admin/coupons/single/update', 'Coupon\CouponController@singleupdate');

Route::post('/admin/coupons/single/create', 'Coupon\CouponController@single_create');

Route::get('/user/coupons/{id}', 'Coupon\UserCouponController@singlecoupon');
Route::post('/user/coupons/single/update', 'Coupon\UserCouponController@singleupdate');

// New Routes
Route::get('/user/coupons', 'Coupon\UserCouponController@index');
Route::get('/user/search_ar_models/{input}', 'Coupon\UserCouponController@search_ar_coupon');
Route::get('user/search_coupons/{input}', 'Coupon\UserCouponController@search_coupons');
Route::get('user/get_coupon_details/{id}', 'Coupon\UserCouponController@get_coupon_details');

Route::post('/user/coupons/create', 'Coupon\UserCouponController@create');
Route::post('/user/coupons/update', 'Coupon\UserCouponController@update');

Route::get('user/get_curr_lable/{promo_id}','Coupon\UserCouponController@get_curr_lable');
