<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkshopCourse extends Model
{
    use HasFactory;

    public function course(){
    	return $this->hasOne('App\Models\CourseUpdate','id','material_id');
    }
    public function workshop(){
    	return $this->hasOne('App\Models\Workshop','id','workshop_id');
    }
}
