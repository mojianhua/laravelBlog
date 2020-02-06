<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public $table = 'article';
    protected $primaryKey = 'art_id';
    public $timestamps = false;
    public $guarded = [];
}
