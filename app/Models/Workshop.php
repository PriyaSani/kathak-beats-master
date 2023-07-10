<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{
    use HasFactory;

    public function workshopfaculty(){
    	return $this->hasMany('App\Models\WorkshopFaculty','workshop_id','id');
    }
    public function workshopstudent(){
        return $this->hasMany('App\Models\WorkshopStudents','workshop_id','id');
    }
    public function studio(){
    	return $this->hasOne('App\Models\Studio','id','studio_id');	
    }
    public function timetable(){
    	return $this->hasMany('App\Models\WorkshopTimetable','workshop_id','id');
    }
    public function course(){
        return $this->hasMany('App\Models\WorkshopCourse','workshop_id','id');
    }
}
