<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\View\Components\Alert;
use App\View\Components\Forms\Input;

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
        //
        view()->share('last_name', "yamada");
        // Blade::component('package-alert', Alert::class);
        // Blade::component('package-input', Input::class);
        
        // ↓うまくいかない
        // Blade::componentNamespace('Nightshade\\Views\\Components', 'nightshade');
    }
}
