<?php

namespace App\Http\Controllers;

// 頭にFacadesをつけることでFacades化が簡単にできる
use Facades\Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Blog;

class BlogViewController extends Controller
{
    
    public function index()
    {
        // $blogs = Blog::get();
        $blogs = Blog::with('user')
                // ->where('status', Blog::OPEN)
                ->OnlyOpen()
                ->withCount('comments')
                ->orderByDesc('comments_count')
                ->get();
        return view('index', compact('blogs'));
    }

    public function show(Blog $blog) 
    {
        // if ($blog->status == Blog::CLOSED) {
        //     abort(403);
        // }
        if ($blog->isClosed()) {
            abort(403);
        }

        $random = Str::random(10);

        return view('blog.show', compact('blog', 'random'));
    }
}
