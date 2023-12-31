<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\AdminResetPasswordNotification;

class Admin extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function sendPasswordResetNotification($token)
    {   
        $this->notify(new AdminResetPasswordNotification($token));
    }

    public function city(){
        return $this->hasOne('App\Models\City','id','city_id');
    }
    public function state(){
        return $this->hasOne('App\Models\State','id','state_id');
    }
    public function dashboard(){
        return $this->hasMany('App\Models\DashboardElement','admin_id','id');
    }
    public function module(){
        return $this->hasMany('App\Models\AdminModule','admin_id','id');
    }
    public function workshop(){
        return $this->hasMany('App\Models\WorkshopFaculty','faculty_id','id');
    }

}
