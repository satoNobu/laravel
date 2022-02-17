<?php

namespace App\Http\Controllers\Mypage;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogMypageController extends Controller
{
    public function index()
    {
        // $blogs = Blog::get();
        // $blogs = Blog::where('user_id', auth()->user()->id)->get();
        $blogs = auth()->user()->blogs;
        return view('mypage.blog.index', compact('blogs'));
    }

    public function create()
    {
        return view('mypage.blog.create');
    }

    public function store(Request $request)
    {
        // $data = $request->all(['title', 'body', 'status']);

        // $data = $request->all(['title', 'body']);
        $data = $request->validate([
            'title' => ['required', 'max:255'],
            'body' => ['required'],
        ]);
        $data['status'] = $request->boolean('status');

        $blog = auth()->user()->blogs()->create($data);

        return redirect('mypage/blogs/edit/'.auth()->user()->id);
    }
}
