<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TestController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/fake', function () {
    Http::fake([
        // GitHubエンドポイントのJSONレスポンスをスタブ
        'example.com/*' => Http::response(['foo' => 'bar'], 200),
    
    ]);
    // Http::dd()->get('https://example.com');
    $response = Http::get('https://example.com');
    dd($response);
    return view('welcome');
});


Route::resource('/user', UserController::class);
Route::resource('/test', TestController::class);