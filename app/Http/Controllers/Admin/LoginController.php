<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//引入自定义验证码包
use App\Org\code\Code;

class LoginController extends Controller
{
    //登录页面路由
    public function index(){
    	return view('admin.login');
    }

    //生成验证码
    public function code(){
    	/*
    	12、自己创建的类应用方法
		12.1：在app目录下新建Org文件件
		12.2：引入包如laravelBlog项目里面admin控制器code方法
		12.3：自动加载composer dump-autoload
		*/
    	$code = new Code();
    	return $code->make();
    }

    public function doLogin(Request $request){
    	//接收数据,除了_token
    	$input = $request->except('_token');
    	// 表单验证
    }
}
