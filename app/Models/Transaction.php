<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public function workshop(){
    	return $this->hasOne('App\Models\Workshop','id','workshop_id');
    }
}
