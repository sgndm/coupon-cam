<?php

Route::get('/admin/promos', 'Promo\PromoController@index');
Route::get('/admin/promos/closed', 'Promo\PromoController@closed');
Route::get('/admin/promos/create', 'Promo\PromoController@create');
Route::get('/admin/promos/create/{id}', 'Promo\PromoController@createbyid');
Route::post('/admin/promos/save', 'Promo\PromoController@save');
Route::get('/admin/promos/edit/{id}', 'Promo\PromoController@edit');
Route::post('/admin/promos/update', 'Promo\PromoController@update');
Route::get('/admin/promos/delete/{id}', 'Promo\PromoController@delete');
Route::get('/admin/promos/trash', 'Promo\PromoController@trash');
Route::get('/admin/promos/restore/{id}', 'Promo\PromoController@restore');
Route::get('/admin/promos/clear/{id}', 'Promo\PromoController@clear');
Route::post('/admin/promos/filter', 'Promo\PromoController@filter');

Route::get('/admin/promos/{company}', 'Promo\PromoController@storesbyuser');
Route::get('/admin/promos/{company}/{id}', 'Promo\PromoController@storesbyuser_pid');
Route::get('admin/generate_new_qr', 'Promo\PromoController@generate_new_qr');



// New  routes
Route::get('/user/promos', 'Promo\UserPromoController@index');
Route::get('user/get_promo_details/{id}', 'Promo\UserPromoController@get_promo_details');
Route::get('user/generate_new_qr', 'Promo\UserPromoController@generate_new_qr');
Route::get('user/delete_old_qr/{file}', 'Promo\UserPromoController@delete_old_qr');
Route::get('user/get_final_promo_stats/{id}', 'Promo\UserPromoController@get_promo_stats');
Route::get('user/search_promos/{input}', 'Promo\UserPromoController@search_promos');

Route::post('/user/promos/create_promo', 'Promo\UserPromoController@create_promo');
Route::post('/user/promos/update_promo', 'Promo\UserPromoController@update_promo');
Route::post('/user/promos/delete_promo', 'Promo\UserPromoController@delete_promo');


Route::get('admin/red_promos', 'Promo\PromoController@redPromoList');
Route::get('admin/red_promos/create', 'Promo\PromoController@redPromoCreate');
Route::get('admin/red_promos/add_coupons', 'Promo\PromoController@addCouponView');
Route::get('admin/red_promos/get_stores/{id}', 'Promo\PromoController@getStoreForPromo');
Route::get('admin/red_promos/get_coupons/{promo_id}/{store_id}', 'Promo\PromoController@getCouponsFromStore');
Route::get('admin/red_promos/save_coupon/{promo_id}/{store_id}/{coupon_id}', 'Promo\PromoController@add_coupon_to_promo');
Route::get('admin/red_promos/remove_coupon/{promo_id}/{coupon_id}', 'Promo\PromoController@remove_coupon_from_promo');
Route::get('admin/red_promos/pause_promo/{promo_id}', 'Promo\PromoController@pause_promo');
Route::get('admin/red_promos/activate_promo/{promo_id}', 'Promo\PromoController@activate_promo');

Route::post('admin/red_promos/save', 'Promo\PromoController@redPromoSave');

// give away
Route::get('admin/give_away/stores', 'Promo\PromoController@gw_store');
Route::get('admin/give_away/promos', 'Promo\PromoController@gw_promos');
Route::get('admin/give_away/coupon', 'Promo\PromoController@gw_coupon');
Route::get('admin/give_away/coupon_list', 'Promo\PromoController@gw_coupon_list');

Route::post('admin/gw_coupon/save', 'Promo\PromoController@gw_coupon_create');
