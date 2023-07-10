<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkshopStudents extends Model
{
    use HasFactory;

    public function users(){
    	return $this->hasOne('App\Models\User','id','student_id');
    }

    public function workshop(){
    	return $this->hasOne('App\Models\Workshop','id','workshop_id');
    }

    public function attandance(){
        return $this->hasOne('App\Models\WorkshopAttendance','workshop_id','workshop_id')->where('status',1);
    }
}
