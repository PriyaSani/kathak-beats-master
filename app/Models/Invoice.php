<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    public function workshop(){
    	return $this->hasOne('App\Models\Workshop','id','workshop_id');
    }

    public function user(){
    	return $this->hasOne('App\Models\User','id','user_id');
    }

    public function invoice_details(){
    	return $this->hasMany('App\Models\InvoiceDetail','invoice_id','id');
    }
    
}
