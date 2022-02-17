<?php

namespace Tests\Feature\Controllers\Mypage;

use Tests\TestCase;
use App\Models\Blog;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BlogMypageControllerTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    function 認証していない場合は、ログイン画面にリダイレクト()
    {
        // ブログマイページ
        $this->get('mypage/blogs')
            ->assertRedirect(route('login'));

        // ログイン新規登録画面
        $this->get('mypage/blogs/create')
            ->assertRedirect(route('login'));
        // ログイン新規登録処理
        $this->post('mypage/blogs/create', [])
            ->assertRedirect(route('login'));
    }
    /** @test index */
    function 認証している場合に、マイページでブログ一覧が表示される()
    {
        // 認証済みの場合
        // $user = User::factory()->create();

        // $this->actingAs($user)->get('mypage/blogs')
        //     ->assertOk();

        $user = $this->login();

        $otherBlog = Blog::factory()->create();
        $myBlog = Blog::factory()->create(['user_id' => $user]);

        $this->get('mypage/blogs')
            ->assertOk()
            ->assertDontSee($otherBlog->title)
            ->assertSee($myBlog->title);
    }

    /** @test */
    function ブログの新規登録画面が開ける()
    {
        $this->login();
        $this->get('mypage/blogs/create')
            ->assertOK();
    }

    /** @test */
    function マイページで新規登録_公開()
    {
        $user = $this->login();
        $validData = Blog::factory()->validData();

        // $this->post('mypage/blogs/create', $validData)
        //     ->assertRedirect('mypage/blogs/edit/'.$user->id);

        $res = $this->post('mypage/blogs/create', $validData);
        $blog = Blog::where($validData)->first()->id;
        $res->assertRedirect('mypage/blogs/edit/'.$blog);
        
        $this->assertDatabaseHas('blogs', $validData);
    }

    /** @test */
    function マイページで新規登録_非公開()
    {
        $user = $this->login();
        $validData = Blog::factory()->validData();
        unset($validData['status']);

        $res = $this->post('mypage/blogs/create', $validData);
        $blog = Blog::where($validData)->first()->id;
        $res->assertRedirect('mypage/blogs/edit/'.$blog);

        $validData['status'] = 0;
        
        $this->assertDatabaseHas('blogs', $validData);
    }

    /** @test */
    function マイページ、ブログの入力チェック()
    {
        // $this->markTestIncomplete('まだ書いてない');
        $url = 'mypage/blogs/create';

        $this->login();

        $this->post($url, ['title' => ''])
            // ->dumpSession()
            ->assertSessionHasErrors(['title' => 'タイトルは必ず指定してください。']);
        $this->post($url, ['title' => str_repeat('a', 256)])
            ->assertSessionHasErrors(['title' => 'タイトルは、255文字以下で指定してください。']);
        $this->post($url, ['title' => str_repeat('a', 255)])
            ->assertSessionDoesntHaveErrors(['title' => 'タイトルは、255文字以下で指定してください。']);

        $this->post($url, ['body' => ''])
            ->assertSessionHasErrors(['body' => '本文は必ず指定してください。']);
    }
}
