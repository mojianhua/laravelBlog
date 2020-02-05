<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cate extends Model
{
    public $table = 'category';
    protected $primaryKey = 'cate_id';
    public $timestamps = false;
    public $guarded = [];
}
