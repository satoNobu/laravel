<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RouteJudgment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // 受信リクエストパスの一致判定
        if ($request->is('one')) {
            \Log::info("受信リクエスト one");
        } else if ($request->is('two')){
            \Log::info("受信リクエスト two");
        } else {
            \Log::info("受信リクエスト ??");
        }

        // 名前付きルートの一致判定
        if ($request->routeIs('route.*')) {
            \Log::info($request->path());
        }

        // URLの取得
        $request->fullUrlWithQuery(['type' => 'test']);
        \Log::info("クエリ文字なし:".$request->url());
        \Log::info("クエリ文字あり:".$request->fullurl());

        // リクエストメソッドの取得
        \Log::info("メソッド:".$request->method());

        // リクエストヘッダの取得
        // デバックツールのheader-request内を見れば色々値がある
        \Log::info("リクエストヘッダ:".$request->header('host','ヘッダなし'));

        //　ヘッダリクエストの確認
        if ($request->hasHeader('host')) {
            \Log::info("ヘッダにhostあり");
        }
        // トークンの取得。ない場合、空もじ
        \Log::info("トークン:".$request->bearerToken());
        // ipアドレスの取得
        \Log::info("IPアドレス:".$request->ip());


        /**
         * コンテンツネゴシエーション
         */
        // リクエストが受け付け可能な全てのコンテンツタイプを返す
        $contentTypes = $request->getAcceptableContentTypes();
        \Log::info($contentTypes);

        if ($request->accepts(['application/json'])) {
            \Log::info("true");
        } else {
            \Log::info("false");
        }

        /**
         * 入力の取得
         */
        // $input = $request->all();
        // $input = $request->collect();
        $input = $request->collect('type')->each(function($type){
            return $type;
        });

        \Log::info($input);
        return $next($request);
    }
}
