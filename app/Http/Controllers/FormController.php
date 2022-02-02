<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // クエリ文字の取得
        // 例：http://0.0.0.0/form?test=111
        $test = $request->query('test', "デフォルト値");
        \Log::info($test);
        $all = $request->query();
        \Log::info($all);
        return view('index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return "create";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 入力項目の制限。本来なら、ミドルウェアなどで実施するべき？
        // $input = $request->only(['name']);
        // $input = $request->except(['name']);
        // dd($input);
        
        $name = $request->input('name');
        \Log::info($name);
        $age = $request->input('info.age', "999");
        \Log::info($age);
        $sex = $request->input('info.sex', "???");
        \Log::info($sex);

        // チェックボックス
        $checkbox = $request->boolean('ckbox');
        \Log::info($checkbox);
        //　日付
        $birthday = $request->date('birthday');
        \Log::info($birthday);

        // 追加入力
        $request->merge(['votes' => 0]);

        $all = $request->input();
        \Log::info($all);

        $request->flash();
        return redirect()->route('form.index')->withInput(
            $request->except('name')
        );

        // ログを見たい場合こっちを有効化
        // return "show"
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return "show";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        return "edit";
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        return "update";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        return "destroy";
    }
}
