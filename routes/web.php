<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MiddlewareTestController;
use App\Http\Middleware\Before;
use App\Http\Middleware\After;
use App\Http\Middleware\Role;
use App\Http\Controllers\RoleController;

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

/*
* ミドルウェア
*/
// Route::get('/before', [MiddlewareTestController::class, 'before'])->name('before')->middleware('before');
// Route::get('/after', [MiddlewareTestController::class, 'after'])->name('after')->middleware('after');

/*
* ミドルウェアの除外
*/
// Route::middleware([Before::class, After::class])->group(function () {
//     Route::get('/before', [MiddlewareTestController::class, 'before'])
//         ->name('before');
//     Route::get('/after', [MiddlewareTestController::class, 'after'])
//         ->name('after')
//         ->withoutMiddleware('before');
// });

/*
* ミドルウェアグループ
*/
// Route::get('/after', [MiddlewareTestController::class, 'after'])->name('after')->middleware('web');
// Route::get('/before', [MiddlewareTestController::class, 'before'])->name('before')->middleware('web');

Route::middleware('web')->group(function() {
    Route::get('/after', [MiddlewareTestController::class, 'after'])->name('after');
    Route::get('/before', [MiddlewareTestController::class, 'before'])->name('before');
});

// Route::middleware('test')->group(function() {
//     Route::get('/after', [MiddlewareTestController::class, 'after'])->name('after');
//     Route::get('/before', [MiddlewareTestController::class, 'before'])->name('before');
// });

Route::get('/role', [RoleController::class, 'role'])->middleware('role:editor');;