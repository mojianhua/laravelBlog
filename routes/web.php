<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix'=>'Admin'],function(){
	# 登录页面路由
	Route::get('/login','Admin\LoginController@index');
	# 验证码路由
	Route::get('/code','Admin\LoginController@code');
});
