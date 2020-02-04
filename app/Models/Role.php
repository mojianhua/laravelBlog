<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $table = 'role';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $guarded = [];
}
