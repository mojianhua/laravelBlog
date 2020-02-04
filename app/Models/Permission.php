<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public $table = 'permission';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $guarded = [];
}
