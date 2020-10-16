<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'title',
        'blog'
    ];

    function get_category() {
        return $this->hasMany('App\Models\BlogCategorySet','blog','id');
    }
}
