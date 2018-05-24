<?php

Route::get('/dashboard', 'User\UserPanelController@index');

Route::get('/coupon/quickform', 'User\UserPanelController@quick_store');
Route::get('/coupon/quickpromo', 'User\UserPanelController@quick_promo');
Route::get('/coupon/quickpromo/store/{id}', 'User\UserPanelController@quick_promo');
Route::get('/coupon/quickpromo/{id}', 'User\UserPanelController@quick_promo_page');
Route::get('/coupon/quickpromo/{id}/{storeid}', 'User\UserPanelController@quick_promo_page');


Route::get('stores/quick_store_create', 'User\UserPanelController@quick_store_page');
Route::post('stores/quick_coupon_create', 'User\UserPanelController@quick_store_create');
Route::get('/quickforms/create_promo', 'User\UserPanelController@quick_promo');
Route::get('/getvaluesofpromo/{id}', 'User\UserPanelController@promoinfo');
Route::post('promos/quickcreate', 'User\UserPanelController@quick_promos_create');
Route::get('/getallaboutstore/{id}', 'User\UserPanelController@getallaboutstore');
Route::get('/getallpromos/{id}', 'User\UserPanelController@getallpromos');

Route::post('/create_promos_now', 'User\UserPanelController@create_promos_now');
Route::get('/quick_coupons/{promoid}/step/{no}', 'User\UserPanelController@create_coupon_quick');
Route::post('/quick_coupon_create', 'User\UserPanelController@quick_coupon_create');
Route::post('/select_store_form','User\UserPanelController@select_store_form');

Route::get('/admin/notify/{id}', 'User\UserPanelController@notify');
Route::get('/profile', 'User\UserPanelController@profile');
Route::get('/user/profile', 'User\UserPanelController@userProfile');
Route::get('/user/team', 'User\UserPanelController@userTeam');
Route::post('/profile/update', 'User\UserPanelController@update');
Route::post('/profile/update', 'User\UserPanelController@update');
Route::get('/retrive/promos','User\UserPanelController@retrive_promos');

Route::get('/settings', 'User\UserPanelController@setting');
Route::get('/user/settings', 'User\UserPanelController@userSetting');
Route::post('/settings', 'User\UserPanelController@settingupdate');

Route::post('/admin/users/update', 'User\UserPanelController@update');
Route::get('/admin/users/delete/{id}', 'User\UserPanelController@delete');
Route::get('/admin/users/trash', 'User\UserPanelController@trash');
Route::get('/admin/users/restore/{id}', 'User\UserPanelController@restore');
Route::get('/admin/users/clear/{id}', 'User\UserPanelController@clear');

Route::get('/user/accept', 'User\UserAcceptController@accept');
Route::post('/user/accept', 'User\UserAcceptController@accepted');
Route::get('/deactivate', 'User\UserPanelController@deactivate');


Route::get('user/select_winner','User\UserPanelController@select_winner' );

Route::get('admin/app_settings', 'User\UserPanelController@app_settings');
Route::post('/change_settings', 'User\UserPanelController@change_app_settings');
Route::post('/change_app_version', 'User\UserPanelController@change_app_version');

Route::post('/update_extend_values', 'User\UserPanelController@update_extend_values');
Route::post('/update_save_limit', 'User\UserPanelController@update_save_limit');

Route::post('user/retarget/create', 'User\UserPanelController@create_retarget');
Route::get('user/retarget/get_details/{store_id}','User\UserPanelController@get_retarget');

Route::post('user/team/create', 'User\UserPanelController@create_member');

Route::get('user/get_act_mem', 'User\UserPanelController@get_active_mems');
Route::get('user/get_inact_mem', 'User\UserPanelController@get_inactive_mems');
Route::get('user/deactivate_member/{user_id}', 'User\UserPanelController@deactivate_member');
Route::get('user/activate_member/{user_id}', 'User\UserPanelController@activate_member');
