<?php

namespace App\Providers;

use App\Models\AdminModule;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {


        
        
        view()->composer('*', function($view){

            if(Auth::user()){
                $getNotification = Notification::where('user_id',Auth::user()->id)->get();
                        
                \View::share('notification',$getNotification);
            }

            if (Auth::guard('admin')->user()) {

                $checkPermission = AdminModule::where('admin_id',Auth::guard('admin')->user()->id)->with(['module'])->get();
               
                $module = array();

                if(!is_null($checkPermission)){
                    foreach($checkPermission as $pk => $pv){
                        $module[] = $pv->module->slug;
                    }
                }

                \View::share('module',$module);
            }
        });
    }
}
