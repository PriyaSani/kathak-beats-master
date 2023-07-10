<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Studio extends Model
{
    use HasFactory;

    public function city(){
        return $this->hasOne('App\Models\City','id','city_id');
    }
    public function state(){
        return $this->hasOne('App\Models\State','id','state_id');
    }
    public function country(){
        return $this->hasOne('App\Models\Country','id','country_id');
    }
}
