<?php

Route::get('/admin/stores', 'Store\StoreController@index');
Route::get('/admin/stores/closed', 'Store\StoreController@closed');
Route::get('/admin/stores/create', 'Store\StoreController@create');
Route::post('/admin/stores/save', 'Store\StoreController@save');
Route::get('/admin/stores/edit/{id}', 'Store\StoreController@edit');
Route::post('/admin/stores/update', 'Store\StoreController@update');
Route::get('/admin/stores/delete/{id}', 'Store\StoreController@delete');
Route::get('/admin/stores/trash', 'Store\StoreController@trash');
Route::get('/admin/stores/restore/{id}', 'Store\StoreController@restore');
Route::get('/admin/stores/clear/{id}', 'Store\StoreController@clear');
Route::post('/admin/stores/filter', 'Store\StoreController@filter');


Route::get('/admin/stores/category', 'Store\StoreCategoryController@index');
Route::get('/admin/stores/category/closed', 'Store\StoreCategoryController@closed');
Route::get('/admin/stores/category/create', 'Store\StoreCategoryController@create');
Route::post('/admin/stores/category/save', 'Store\StoreCategoryController@save');
Route::get('/admin/stores/category/edit/{id}', 'Store\StoreCategoryController@edit');
Route::post('/admin/stores/category/update', 'Store\StoreCategoryController@update');
Route::get('/admin/stores/category/delete/{id}', 'Store\StoreCategoryController@delete');
Route::get('/admin/stores/category/trash', 'Store\StoreCategoryController@trash');
Route::get('/admin/stores/category/restore/{id}', 'Store\StoreCategoryController@restore');
Route::get('/admin/stores/category/clear/{id}', 'Store\StoreCategoryController@clear');
Route::post('/admin/stores/category/filter', 'Store\StoreCategoryController@filter');



Route::get('/user/stores/category', 'Store\UserStoreCategoryController@index');
Route::get('/user/stores/category/closed', 'Store\UserStoreCategoryController@closed');
Route::get('/user/stores/category/create', 'Store\UserStoreCategoryController@create');
Route::post('/user/stores/category/save', 'Store\UserStoreCategoryController@save');
Route::get('/user/stores/category/edit/{id}', 'Store\UserStoreCategoryController@edit');
Route::post('/user/stores/category/update', 'Store\UserStoreCategoryController@update');
Route::get('/user/stores/category/delete/{id}', 'Store\UserStoreCategoryController@delete');
Route::get('/user/stores/category/trash', 'Store\UserStoreCategoryController@trash');
Route::get('/user/stores/category/restore/{id}', 'Store\UserStoreCategoryController@restore');
Route::get('/user/stores/category/clear/{id}', 'Store\UserStoreCategoryController@clear');
Route::post('/user/stores/category/filter', 'Store\UserStoreCategoryController@filter');

Route::get('/user/stores/new_category', 'Store\UserStoreCategoryController@new_category');






// New Routes
Route::get('/user/stores', 'Store\UserStoreController@index');
Route::get('/user/get_active_store', 'Store\UserStoreController@get_active_stores');
Route::get('/user/get_closed_store', 'Store\UserStoreController@get_closed_stores');
Route::get('/user/search_stores/{input}', 'Store\UserStoreController@search_store');
Route::get('/user/get_store_details/{id}', 'Store\UserStoreController@get_user_details_by_id');

Route::post('/user/stores/create_store', 'Store\UserStoreController@create_store');
Route::post('/user/stores/update_store', 'Store\UserStoreController@update_store');
Route::post('/user/stores/delete_store', 'Store\UserStoreController@delete_store');