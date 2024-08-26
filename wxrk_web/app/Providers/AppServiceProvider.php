<?php

namespace App\Providers;

use View;
use App\Models\Module;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        // $Clientusers = User::where('user_type','=','user')->get();
        //     View::share('Clientusers', $Clientusers);



        // $pagename = request()->segment(count(request()->segments()));
        // $ametatags = DB::select("SELECT * FROM  tblmetatag where pagename='".$pagename."'");
        // View::share('ametatags', $ametatags);


        Validator::extend('max_mb', function ($attribute, $value, $parameters, $validator) {
            $megabytes = $value->getSize() / 1024 / 1024;
            if ($megabytes > 150) {
                return false;
            } else {
                return true;
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}