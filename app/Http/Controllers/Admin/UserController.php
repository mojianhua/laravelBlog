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
    public function index(Request $request)
    {   
        // 获取所有数据
        // $user = User::get();

        //分页获取数据
        // $user = User::paginate(3);

        $input = $request->all();
        $user = User::OrderBy('user_id','asc')
                ->where(function($query) use ($request){
                    $user_name = $request->input('user_name');
                    $email = $request->input('email');
                    if(!empty($user_name)){
                        $query->where('user_name','like','%'.$user_name.'%');
                    }

                    if(!empty($email)){
                        $query->where('email','like','%'.$email.'%');
                    }
                })
                ->paginate($request->input('num') ? $request->input('num') : 2);
        return view('admin.user.user_list',compact('user','request'));
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
        $user = User::find($id);
        return view('admin.user.user_edit',compact('user'));
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
        $user = User::find($id);
        $user_name = $request->input('email');
        $pass = Crypt::encrypt($request->input('pass'));
        $user->user_name = $user_name;
        $user->user_pass = $pass;
        $res = $user->save();
        if($res){
            $msg = ['status'=>200,'msg'=>'修改成功'];
        }else{
            $msg = ['status'=>0,'msg'=>'修改失败'];
        }
        return $msg;
    }

    /**
     * 用户删除
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $res = $user->delete();
        if($res){
            $msg = ['status'=>200,'msg'=>'删除成功'];
        }else{
            $msg = ['status'=>0,'msg'=>'删除失败'];
        }
        return $msg;
    }

    //批量删除用
    public function delAll(Request $request){
       $input = $request->input('ids');
       $res = User::destroy($input);
        if($res){
            $msg = ['status'=>200,'msg'=>'删除成功'];
        }else{
            $msg = ['status'=>0,'msg'=>'删除失败'];
        }
        return $msg;
    }
}
