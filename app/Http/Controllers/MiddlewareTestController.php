<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MiddlewareTestController extends Controller
{
    public function before()
    {
        \Log::info('beforeスタート');
        return 'before';
    }

    public function after()
    {
        \Log::info('afterスタート');
        return 'after';
    }
}
