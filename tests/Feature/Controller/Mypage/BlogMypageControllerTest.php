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
        // ログイン 編集
        $this->get('mypage/blogs/edit/1')
            ->assertRedirect(route('login'));
        // ログイン 更新
        $this->post('mypage/blogs/edit/1')
            ->assertRedirect(route('login'));

        // 削除
        $this->delete('mypage/blogs/delete/1')
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

    /** @test edit*/
    function 他ユーザーのブログ編集画面は開ない()
    {
        $blog = Blog::factory()->create();
        $this->login();

        $this->get('mypage/blogs/edit/'.$blog->id)
            ->assertForbidden();
    }

    /** @test update*/
    function 他ユーザーのブログは更新できない()
    {
        // $this->markTestIncomplete('未実装');
        $validData = [
            'title' => '新タイトル',
            'body' => '新本文',
            'status' => '1',
        ];
        $blog = Blog::factory()->create();;
        $this->login();

        $this->post(route('mypage.blog.update', $blog), $validData)
            ->assertForbidden();

        // form側で変更している可能性もあるのでおすすめではない。パスワードとか
        // $this->assertDatabaseMissing('blogs', $validData);

        $this->assertCount(1, Blog::all());
        $this->assertEquals($blog->toArray(), Blog::first()->toArray());
    }

    /** @test delete*/
    function 他ユーザーのブログは削除できない()
    {
        $blog = Blog::factory()->create();

        $this->login();

        $this->delete('mypage/blogs/delete/'.$blog->id)
            ->assertForbidden();

        $this->assertCount(1, Blog::all());
    }

    /** @test edit*/
    function 自分のブログ編集画面が開ける()
    {
        $blog = Blog::factory()->create();

        $this->login($blog->user);
        dump($blog->user->id);
        $this->get(route('mypage.blog.edit', $blog))
            ->assertOk();

    }

    /** @test edit*/
    function 自分のブログは更新できる()
    {
        $validData = [
            'title' => '新タイトル',
            'body' => '新本文',
            'status' => '1',
        ];
        $blog = Blog::factory()->create();;
        $this->login($blog->user);

        $this->post(route('mypage.blog.update', $blog), $validData)
            ->assertRedirect(route('mypage.blog.edit', $blog));

            dump(route('mypage.blog.edit', $blog));
        $this->get(route('mypage.blog.edit', $blog))
            ->assertSee('ブログを更新しました');

        $this->assertDatabaseHas('blogs', $validData);

        // 更新かはっきりしない。新規登録かもしれないので以下で確認
        $this->assertCount(1, Blog::all());
        $this->assertEquals(1, Blog::count());
        
        // データがまだ変わっていない状態なのでエラー。freshを使うとOK
        // $this->assertEquals('新タイトル', $blog->title);
        $this->assertEquals('新タイトル', $blog->fresh()->title);
        $this->assertEquals('新本文', $blog->fresh()->body);

        // 項目が多い時は、refresh()を使う
        $blog->refresh();
        $this->assertEquals('新本文', $blog->body);
        // $this->assertEquals('新本文', $blog->body);
        // $this->assertEquals('新本文', $blog->body);
        // $this->assertEquals('新本文', $blog->body);
        // $this->assertEquals('新本文', $blog->body);
        // $this->assertEquals('新本文', $blog->body);
        // $this->assertEquals('新本文', $blog->body);
    }

    /** @test destroy */
    function 自分のブログは削除できる()
    {
        $blog = Blog::factory()->create();

        $this->login($blog->user);

        $this->delete('mypage/blogs/delete/'.$blog->id)
            ->assertRedirect('mypage/blogs');

        // $this->assertDatabaseMissing('blogs', ['id' => $blog->id]);  // $blog->only('id)
        $this->assertDeleted($blog);
    }
}
