<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LatestWork extends Model
{
    use HasFactory;

    public function video(){
    	return $this->hasMany('App\Models\LatestWorkVideo','latest_work_id','id');
    }
}
