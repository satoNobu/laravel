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
        // $data = $request->validate([
        //     'title' => ['required', 'max:255'],
        //     'body' => ['required'],
        // ]);
        $data = $this->validateInput();
        $data['status'] = $request->boolean('status');

        $blog = auth()->user()->blogs()->create($data);

        return redirect('mypage/blogs/edit/'.$blog->id);
    }

    public function edit(Blog $blog, Request $request)
    {
        // ブログのユーザー以外は、403
        if ($request->user()->isNot($blog->user)) {
            abort(403);
        }

        // エラー時は、直前のデータ復旧させる
        $data = old() ?: $blog;

        return view('mypage.blog.edit', compact('blog', 'data'));
    }
    

    public function update(Blog $blog, Request $request)
    {
        dump('---');
        $data = $this->validateInput();
        dump($data);
        $data['status'] = $request->boolean('status');

        $blog->update($data);

        return redirect(route('mypage.blog.edit', $blog))
            ->with('status', 'ブログを更新しました');
            
        
    }

    private function validateInput()
    {
        return request()->validate([
            'title' => ['required', 'max:255'],
            'body' => ['required'],
        ]);
    }
}
