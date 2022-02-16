<?php

namespace Tests\Feature\Controllers\Mypage;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/** @see  App\Http\Controllers\Mypage\UserLoginController */
class UserLoginControllerTest extends TestCase
{

    /** @test index */
    public function ログイン画面が表示できる()
    {
        $this->get('mypage/login')
            ->assertOk();
    }
}
