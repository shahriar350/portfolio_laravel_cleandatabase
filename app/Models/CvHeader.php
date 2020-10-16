<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CvHeader extends Model
{
    use HasFactory;

    function get_body(){
        return $this->hasMany('App\Models\CvBody','header_id','id');
    }
}
