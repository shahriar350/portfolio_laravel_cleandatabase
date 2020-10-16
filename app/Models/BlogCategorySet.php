<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogCategorySet extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
          'category','blog'
    ];

    function get_name() {
        return $this->hasOne('App\Models\BlogCategory','id','category');
    }
}
