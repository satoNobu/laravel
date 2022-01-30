<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServiceConTestController extends Controller
{

    /**
     * 新しいコントローラインスタンスの生成
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * サービスコンテナの強み
     * 1. 依存解決
     */
    public function func() 
    {
        $this->meritOne();
        return view('sample');
    }

    private function meritOne()
    {
        // $classC = new ClassC();
        // $classB = new ClassB($classC);
        // $classA = new ClassA($classB);

        $classA = app()->make(ClassA::class);
        // ■ log
        // local.INFO: ClassCインスタンス化完了  
        // local.INFO: ClassBインスタンス化完了  
        // local.INFO: ClassAインスタンス化完了  
    }

    /**
     * サービスコンテナの強み
     * 2. インスタンス化の方法をカスタマイズ
     */
    public function func2()
    {
        $this->meritTwo();
        return view('sample');
    }

    private function meritTwo()
    {
        // ★ Providers\AppServiceProvider.phpに書くのが通常
        // インスタンス方法をカスタマイズ
        // app()->bind(ClassD::class, function () {
        //     $classX = new ClassD();
        //     $classX->foo = 'bar';
        //     return $classX;
        // });
        // app()->resolving(ClassD::class, function ($obj, $app) {
        //     // オブジェクトを解決するときに呼び出される
        //     \Log::info("RRRRRRR");
        //     \Log::info($obj->foo);
        // });
        \Log::info('Start');
        // インスタンス化 
        $classD = app()->make(ClassD::class); 
        \Log::info($classD->foo);
        \Log::info('End');
    }
}

class ClassA
{
    public function __construct(ClassB $classB)
    {
        \Log::info('ClassAインスタンス化完了');
    }
}

class ClassB
{
    public function __construct(ClassC $classC)
    {
        \Log::info('ClassBインスタンス化完了');
    }
}

class ClassC
{
    public function __construct()
    {
        \Log::info('ClassCインスタンス化完了');
    }
}

class ClassD
{
    public $foo;

    public function __construct()
    {
        \Log::info('ClassD instantiated:');
    }
}