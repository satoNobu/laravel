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

    /** @test login */
    function ログイン時の入力チェック()
    {
        $url = 'mypage/login';

        $this->from($url)->post($url, [])
            ->assertRedirect($url);

        $this->post($url, ['email' => ''])->assertSessionHasErrors(['email' => 'メールアドレスは必ず指定してください。']);
        $this->post($url, ['email' => 'aaa@bbb@ccc'])->assertSessionHasErrors(['email' => 'メールアドレスには、有効なメールアドレスを指定してください。']);
        $this->post($url, ['email' => 'ああああ@ccc'])->assertSessionHasErrors(['email' => 'メールアドレスには、有効なメールアドレスを指定してください。']);

        $this->post($url, ['password' => ''])->assertSessionHasErrors(['password' => 'パスワードは必ず指定してください。']);
    }
}
