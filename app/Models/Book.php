<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    /**
     * モデルに関連付けるテーブル
     *
     * @var string
     */
    // テーブル名が規則に沿ってない（複数形じゃない）ので必要
    protected $table = 'book';

        /**
     * テーブルに関連付ける主キー
     *
     * @var string
     */
    protected $primaryKey = 'name';
    // 文字列を主キーとする場合、falseにしないと文字列が取得できない
    public $incrementing = false;
}
