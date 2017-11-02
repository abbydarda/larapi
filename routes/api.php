<?php

use Illuminate\Http\Request;

Route::get('users','UserController@users');
Route::get('users/profile','UserController@profile')->middleware('auth:api');
Route::post('auth/register','AuthController@register');
Route::post('auth/login','AuthController@login');
Route::post('post','PostController@add')->middleware('auth:api');
Route::get('list','PostController@list')->middleware('auth:api');
Route::put('update/{id}','PostController@update')->middleware('auth:api');
