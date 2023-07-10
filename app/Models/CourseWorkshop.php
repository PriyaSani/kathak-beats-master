<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseWorkshop extends Model
{
    use HasFactory;

    public function material(){
    	return $this->hasMany('App\Models\CourseUpdate','course_id','course_id');	
    }
    public function workshop(){
    	return $this->hasOne('App\Models\Course','id','course_id');	
    }
}
