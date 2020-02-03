<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
//引入自定义验证码包
use App\Org\code\Code;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class LoginController extends Controller
{
    //登录页面路由
    public function Login(){
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

    //登录逻辑
    public function doLogin(Request $request){
    	//接收数据,除了_token
    	$input = $request->except('_token');
    	$rule = [
    			'username' => 'required|between:4,18',
    			'password' => 'required|between:4,18|alpha_dash',
                # 验证码验证规则,如出现validation.captcha验证不对，则在语音包自定义验证字段
                'captcha'=>'required|captcha'
    		];
    	$msg = [
            'username.required'=>'用户名必须输入',
            'username.between'=>'用户名长度必须在4-18位之间',
            'password.required'=>'密码必须输入',
            'password.between'=>'密码长度必须在4-18位之间',
            'password.alpha_dash'=>'密码必须是数组字母下滑线',
            'captcha.required'=>'验证码必须输入',
            'captcha.captcha'=>'验证码错误',
        ];
    	// Validator::make(验证数据,验证规则,语音包);
    	$validator = Validator::make($input,$rule,$msg);

    	if($validator->fails()){
    		return redirect('Admin/login')->withErrors($validator)->withInput();
    	}

    	//验证用户数据
    	$user = User::where('user_name',$input['username'])->first();
    	if (!$user){
    		return redirect('Admin/login')->with('username','用户名错误');
    	}

    	if ($input['password'] != Crypt::decrypt($user->user_pass)){
    		return redirect('Admin/login')->with('password','密码错误');
    	}

    	//保存用户信息到session中

        session()->put('user',$user);

		//跳转到后台首页
        return redirect('Admin/index');
    }

    //后台首页
    public function index(){
    	return view('admin.index');
    }

    //后台欢迎页
    public function welcome(){
    	return view('admin.welcome');
    }

    //后台退成登录
    public function loginOut(){
    	//清空session
    	session()->flush();
    	return redirect('Admin/login');
    }

    // laravel加密
	public function jiami(){
		$str = '123456';
		// // laravel哈希加密
		// $hash = Hash::make($str);
		// // laravel哈希验证
		// if (Hash::check($str,$hash)){
		// 	return '密码正确';
		// }else{
		// 	return '密码不正确';
		// }

		// crypt加密
		// $crypt_str = Crypt::encrypt($str);
		// return $crypt_str;
		// // crypt解密
		// $crypt_str = 'eyJpdiI6InhZaUE1VTlrWFVLclo0cTczVFdNUWc9PSIsInZhbHVlIjoiRVZhOVBSQ1FTRlFhSUVxUkp4OWN2Zz09IiwibWFjIjoiMTNjZjk1YTE5ZTc5NDkzZjQxMTQwOTg1ODYwN2YzYjQzNTcyOWVmZmVlYTc2ZTNjYWU2YmY3NjMzNjBhMmRlMiJ9';
		// if(Crypt::decrypt($crypt_str) == $str){
		// 	return '密码正确';
		// }else{
		// 	return '密码不正确';
		// }
	}
}
