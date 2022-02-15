<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;

class BlogViewController extends Controller
{
    
    public function index()
    {
        // $blogs = Blog::get();
        $blogs = Blog::withCount('comments')->get();
        return view('index', compact('blogs'));
    }
}
