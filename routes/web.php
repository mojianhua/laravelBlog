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
Route::group(['prefix'=>'Admin','namespace'=>'Admin','middleware'=>['isLogin','hasRole']],function(){
	# 后台首页
	Route::get('/index','LoginController@index');
	# 欢迎页
	Route::get('/welcome','LoginController@welcome');
	# 退出登录
	Route::get('/loginout','LoginController@loginOut');
	# 批量删除用户
	Route::get('user/del','UserController@delAll');
	# 用户模块
	Route::resource('/user','UserController');
	# 角色模块
	# 批量删除角色
	Route::get('/role/del','RoleController@delAll');
	# 查看权限
	Route::get('/role/auth/{id}','RoleController@auth');
	# 权限更新
	Route::post('/role/doauth','RoleController@doAuth');
	# 创建rest风格命令
	# php artisan make:controller Admin/RoleController --resource
	Route::resource('/role','RoleController');
	# 分类路由
	Route::resource('/cate','CateController');
});
