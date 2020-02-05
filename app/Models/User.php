<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $table = 'user';
    protected $primaryKey = 'user_id';
    public $timestamps = false;
    public $guarded = [];

    //查询用户角色
    public function role(){
    	return $this->belongsToMany('App\Models\Role','user_role','user_id','role_id');
    }
}
