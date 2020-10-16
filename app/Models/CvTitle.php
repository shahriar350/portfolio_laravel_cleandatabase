<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CvTitle extends Model
{
    use HasFactory;

    function get_header(){
        return $this->hasMany('App\Models\CvHeader','title_id','id');
    }
}
