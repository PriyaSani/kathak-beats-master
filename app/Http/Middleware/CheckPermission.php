<?php

namespace App\Http\Middleware;

use App\Models\AdminModule;
use Closure;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        $checkPermission = AdminModule::where('admin_id',Auth::guard('admin')->user()->id)->with(['module'])->get();
               
        $module = array();

        if(!is_null($checkPermission)){
            foreach($checkPermission as $pk => $pv){
                $module[] = $pv->module->slug;
            }
        }

        if(in_array(request()->segment(2),$module) || 
            \Route::is('admin.dashboard') ||
            \Route::is('changeAdminPassword') ||
            \Route::is('updateAdminPassword') ||
            \Route::is('admin.profile') ||
            \Route::is('updateProfile')
        ){
            return $next($request);
        } else {
            abort('403');
        }
    }
}



