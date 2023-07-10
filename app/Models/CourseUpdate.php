<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseUpdate extends Model
{
    use HasFactory;

    public function course(){
    	return $this->hasOne('App\Models\Course','id','course_id');	
    }

    public function workshop(){
    	return $this->hasMany('App\Models\WorkshopCourse','material_id','id');	
    }
}
