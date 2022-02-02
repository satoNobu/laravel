<?php

use Illuminate\Support\Facades\Route;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/str', function () {
    return 'Hello World';
});

Route::get('/array', function () {
    return [1, 2, 3];
});

Route::get('/home', function () {
    return response('Hello World!!!', 200)
                  ->header('Content-Type', 'text/plain');
});

Route::resource('/test', TestController::class);
