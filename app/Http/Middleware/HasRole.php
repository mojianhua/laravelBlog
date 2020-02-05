<?php

namespace App\Http\Middleware;

use Closure;
use Route;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

class HasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // 获取当前请求路由
        $route = Route::current()->getAction();
        // 获取当前用户权限组
        $user = User::find(session()->get('user')->user_id);
        //获取当前用户角色
        $roles = $user->role;
        //获取对应的权限列表
        $per_arr = [];
        foreach ($roles as $key => $value) {
            foreach ($value->permission as $k => $v) {
               $per_arr[] = $v->per_url;
            };
        }
        //去重
        $per_arr = array_unique($per_arr);
        if(in_array($route['controller'], $per_arr)){
            return $next($request);
        }else{
            //echo "没权限";
            return $next($request);
        }
    }
}
