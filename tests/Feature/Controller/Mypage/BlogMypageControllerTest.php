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
        $this->get('mypage/blogs')
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
}
