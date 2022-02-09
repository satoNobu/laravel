<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;
    // use SoftDeletes;

    /**
     * モデルの「起動」メソッド
     *
     * @return void
     */
    protected static function booted()
    {
        // static::addGlobalScope('test', function (Builder $builder) {
        //     $builder->where('created_at', '<', now()->subYears(2000));
        // });
    }

    public function phone()
    {
        return $this->hasOne(Phone::class);
    }
}
