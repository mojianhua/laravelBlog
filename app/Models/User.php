<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $table = 'user';
    protected $primaryKey = 'user_id';
    public $timestamps = false;
    public $guarded = [];
}
