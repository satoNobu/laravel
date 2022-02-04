<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/greeting', function () {
//     return view('greeting', ['first_name' => 'taro']);
// });

// 値の渡し方は、with()でも可能
Route::get('/greeting', function () {
    return view('greeting') 
        -> with('first_name','taro')
        -> with('js_value', 'js-');
});

Route::get('/bye', function () {
    return view('test.bye');
});

Route::get('/loop', function () {
    return view('loop') -> with('str_ary', ['a','b','c', 'd']);
});

Route::get('/class', function () {
    return view('class');
});

Route::get('/parent', function () {
    return view('subView.parent');
});

Route::get('/collection', function () {
    return view('collection.collection');
});

Route::get('/component', function () {
    return view('component');
});
