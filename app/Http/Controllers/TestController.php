<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

class TestController extends Controller
{
    public function func() 
    {
        // 環境取得、
        $env = APP::environment();
        $config = config('app.timezone', 'Asia');
        config(['app.timezone' =>  'Tokyo']);
        $config2 = config('app.timezone', 'Asia');

        // 現在のルートの確認
        $route = Route::current(); // Illuminate\Routing\Route
        $name = Route::currentRouteName(); // 文字列
        $action = Route::currentRouteAction(); // 文字列

        dd($env, $config, $config2, $route, $name, $action);
        return view('test');
    }
}
