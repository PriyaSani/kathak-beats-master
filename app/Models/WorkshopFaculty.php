<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkshopFaculty extends Model
{
    use HasFactory;

    public function faculty(){
    	return $this->hasOne('App\Models\Admin','id','faculty_id');
    }
    public function workshop(){
    	return $this->hasOne('App\Models\Workshop','id','workshop_id');
    }
    
}
