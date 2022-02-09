<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Test;
class Phone extends Model
{
    use HasFactory;

    public function test()
    {
        return $this->belongsTo(Test::class, 'test_id');
    }
}
