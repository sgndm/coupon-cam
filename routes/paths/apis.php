<?php


Route::get('/api/all_stores/{userid}', 'Api\ApiController@allstores');
Route::get('/api/store/{userid}/{id}', 'Api\ApiController@store');

Route::get('/api/all_promos/{userid}', 'Api\ApiController@allpromo');
Route::get('/api/all_promos_store/{userid}/{storeid}', 'Api\ApiController@allpromo_store');
Route::get('/api/promo/{userid}/{promoid}', 'Api\ApiController@promo');

Route::get('/api/all_coupons/{userid}/{promoid}', 'Api\ApiController@allcoupons');
Route::get('/api/coupon/{userid}/{promoid}/{couponid}', 'Api\ApiController@coupon');


