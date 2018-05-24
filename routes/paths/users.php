<?php

Route::get('/admin/users', 'User\UserController@index');
Route::get('/admin/users/create', 'User\UserController@create');
Route::post('/admin/users/save', 'User\UserController@save');
Route::get('/admin/users/edit/{id}', 'User\UserController@edit');
Route::post('/admin/users/update', 'User\UserController@update');
Route::get('/admin/users/delete/{id}', 'User\UserController@delete');
Route::get('/admin/users/trash', 'User\UserController@trash');
Route::get('/admin/users/restore/{id}', 'User\UserController@restore');
Route::get('/admin/users/clear/{id}', 'User\UserController@clear');
Route::post('/admin/users/filter', 'User\UserController@filter');