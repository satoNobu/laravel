<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function login(User $user = null)
    {
        $user = $user ?? User::factory()->create();

        // 指定ユーザーを現在のユーザーとして認証する
        $this->actingAs($user);

        return $user;
    }
}
