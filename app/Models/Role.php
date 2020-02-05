<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $table = 'role';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $guarded = [];

    //关联权限表
    public function permission(){
    	return $this->belongsToMany('App\Models\Permission','role_permission','role_id','permission_id');
    }
}
