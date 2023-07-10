<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkshopAttendance extends Model
{
    use HasFactory;

    public function workshop(){
    	return $this->hasOne('App\Models\Workshop','id','workshop_id');
    }
    public function detail(){
        return $this->hasMany('App\Models\WorkshopAttendanceDetail','workshop_attendance_id','id');
    }
}
