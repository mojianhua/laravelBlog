<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    /**
     * 用户列表
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.user.user_list');
    }

    /**
     * 用户添加页面
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.user_add');
    }

    /**
     * 用户添加
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $username = $input['email'];
        $pass = Crypt::encrypt($input['pass']);
        $res = User::create(['user_name'=>$username,'user_pass'=>$pass,'email'=>$username]);
        if($res){
            $msg = ['status'=>200,'msg'=>'添加成功'];
        }else{
            $msg = ['status'=>0,'msg'=>'添加失败'];
        }
        return $msg;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * 查看页码
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 用户修改
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 用户删除
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
