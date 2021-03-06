<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   $input = $request->all();
        $role = Role::OrderBy('id','asc')
                ->where(function($query) use ($request){
                    $role_name = $request->input('role_name');
                    if (!empty($role_name)){
                        $query->where('role_name','like','%'.$role_name.'%');
                    }
                })
                ->paginate($request->input('num') ? $request->input('num') : 3);
        return view('admin.role.role_list',compact('role','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.role.role_add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $role_name = $input['role_name'];
        $res = Role::create(['role_name'=>$role_name]);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        return view('admin.role.role_edit',compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        $role_name = $request->input('role_name');
        $role->role_name = $role_name;
        $res = $role->save();
        if($res){
            $msg = ['status'=>200,'msg'=>'修改成功'];
        }else{
            $msg = ['status'=>0,'msg'=>'修改失败'];
        }
        return $msg;


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::find($id);
        $res = $role->delete();
        if($res){
            $msg = ['status'=>200,'msg'=>'删除成功'];
        }else{
            $msg = ['status'=>0,'msg'=>'删除失败'];
        }
        return $msg;
    }

    //批量删除
    public function delAll(Request $request){
       $input = $request->input('ids');
       $res = Role::destroy($input);
        if($res){
            $msg = ['status'=>200,'msg'=>'删除成功'];
        }else{
            $msg = ['status'=>0,'msg'=>'删除失败'];
        }
        return $msg;
    }

    //查看权限
    public function auth($id){
        // 获取当前角色
        $role = Role::find($id);
        //权限列表
        $perms = Permission::get();
        // 获取当前角色拥有的权限
        $own_pers = [];
        $own_perms = $role->Permission;
        foreach ($own_perms as $key => $value) {
            $own_pers[] = $value->id;
        }
        return view('admin.role.auth',compact('role','perms','own_pers'));
    }

    //更新权限
    public function doAuth(Request $request){
        $input = $request->except('_token');
        //删除权限
        $role = DB::table('role_permission')->where('role_id',$input['role_id'])->delete();
        foreach ($input['perssion_id'] as $key => $value) {
            DB::table('role_permission')->insert(['role_id'=>$input['role_id'],'permission_id'=>$value]);
        }
        $res = 1;
        if($res){
            $msg = ['status'=>200,'msg'=>'更新成功'];
        }else{
            $msg = ['status'=>0,'msg'=>'更新失败'];
        }
        return $msg;
    }
}
