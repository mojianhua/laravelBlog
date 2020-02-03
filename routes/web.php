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

Route::group(['prefix'=>'Admin','namespace'=>'Admin'],function(){
	# 后台首页
	Route::get('/login','LoginController@Login');
	# 后台登录逻辑
	Route::post('/dologin','LoginController@doLogin');
	# 加密
	Route::get('/jiami','LoginController@jiami');
});

//prefix表示url前缀，如：http://test.bloglaravel.com:8888/Admin/login中的Admin
//namespace命名空间，将Admin\LoginController@code变成LoginController@code可直接访问
//middleware中间件名
Route::group(['prefix'=>'Admin','namespace'=>'Admin','middleware'=>'isLogin'],function(){
	# 后台首页
	Route::get('/index','LoginController@index');
	# 欢迎页
	Route::get('/welcome','LoginController@welcome');
	# 退出登录
	Route::get('/loginout','LoginController@loginOut');
});
