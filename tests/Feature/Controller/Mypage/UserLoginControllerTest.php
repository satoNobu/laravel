<?php

namespace Tests\Feature\Controllers\Mypage;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/** @see  App\Http\Controllers\Mypage\UserLoginController */
class UserLoginControllerTest extends TestCase
{
    use RefreshDatabase;

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

    /** @test */
    function ログイン可能()
    {
        $postData = [
            'email' => 'aaa@bbc.ccc.net',
            'password' => 'test12345',
        ];

        $dbData = [
            'email' => 'aaa@bbc.ccc.net',
            'password' => bcrypt('test12345'),
        ];

        $user = User::factory()->create($dbData);

        $this->post('mypage/login', $postData)
            ->assertRedirect('mypage/blogs');

        $this->assertAuthenticatedAs($user);

    }

    /** @test */
    function ID間違いのためログイン不可()
    {
        $postData = [
            'email' => 'aaa@bbc.ccc.net',
            'password' => 'test12345',
        ];

        $dbData = [
            'email' => 'zzz@bbc.ccc.net',
            'password' => bcrypt('test12345'),
        ];

        $user = User::factory()->create($dbData);

        $url = 'mypage/login';

        $this->from($url)
            ->post($url, $postData)
            ->assertRedirect($url);

        $this->get($url)
            ->assertSee('メールアドレスかパスワードが間違っています。');

        // $this->from($url)
        //     ->followingRedirects()
        //     ->post($url, $postData)
        //     ->assertSee('メールアドレスが間違っています。')
        //     // ->assertSee('<h1>ログイン画面</h1>', false);
        //     ->assertSeeText('ログイン画面');
    }

        /** @test */
    function パスワード間違いのためログイン不可()
    {
        $postData = [
            'email' => 'aaa@bbc.ccc.net',
            'password' => 'test9999',
        ];

        $dbData = [
            'email' => 'aaa@bbc.ccc.net',
            'password' => bcrypt('test12345'),
        ];

        $user = User::factory()->create($dbData);

        $url = 'mypage/login';

        $this->from($url)
            ->post($url, $postData)
            ->assertRedirect($url);

        $this->get($url)
            ->assertSee('メールアドレスかパスワードが間違っています。');

        // $this->from($url)
        //     ->followingRedirects()
        //     ->post($url, $postData)
        //     ->assertSee('メールアドレスが間違っています。')
        //     // ->assertSee('<h1>ログイン画面</h1>', false);
        //     ->assertSeeText('ログイン画面');
    }

    /** @test */
    function ログアウトできること()
    {
        $this->login();

        $this->post('mypage/logout')
            ->assertRedirect(route('login'));
        
        $this->get(route('login'))
            ->assertSee('ログアウトしました');

        $this->assertGuest();
    }
}
