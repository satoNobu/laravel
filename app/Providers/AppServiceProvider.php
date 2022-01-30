<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\ClassD;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // ServiceConTestControllerのClassD
        app()->bind(ClassD::class, function () {
            $classX = new ClassD();
            $classX->foo = 'bar';
            return $classX;
        });
        app()->resolving(ClassD::class, function ($obj, $app) {
            // オブジェクトを解決するときに呼び出される
            \Log::info("RRRRRRR");
            \Log::info($obj->foo);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
