<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    public function batch(){
    	return $this->hasOne('App\Models\Workshop','id','batch_workshop_id');
    }
    public function material(){
    	return $this->hasMany('App\Models\CourseUpdate','course_id','id');	
    }
}
