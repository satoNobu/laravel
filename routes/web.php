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

// controllerなし、view直指定
Route::middleware(['throttle:rateTest'])->group(function () {
    Route::view('/sample', 'sample');
});

// リダイレクト
Route::redirect('/redirect', '/')->name('redirect');

// オプションパラメータの指定
Route::get('/test/{name?}',  function ($name = "デフォルト値") {
    return $name;
});

// パラメーターフォーマット制約。フォーマットエラー時は404
// Route::get('/test2/{name?}',  function ($name = 9999) {
//     return $name;
// }) -> where('name', '[0-9]+');

Route::get('/test2/{name?}',  function ($name = 9999) {
    return $name;
}) -> whereNumber('name');

Route::get('/func', [TestController::class, 'func'])->name('func');

Route::prefix('admin')->group(function () {
    Route::get('/users', function () {
        // /admin/usersのURLに一致
        return "/admin/usersのURLに一致";
    });
});

Route::name('admin.')->group(function () {
    Route::get('/users', function () {
        // ルートに"admin.users"が名付けられる
        return "/";
    })->name('users');
});

// 404のカスタマイズ
Route::fallback(function () {
    return "存在しないURL";
});