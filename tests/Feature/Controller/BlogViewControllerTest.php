<?php

namespace Tests\Feature\Controllers;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Blog;
use App\Models\User;
use App\Models\Comment;
use App\Http\Middleware\BlogShowLimit;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BlogViewControllerTest extends TestCase
{
    use RefreshDatabase;

    // これすると、他のミドルウェアも無効化されるのでNG
    // use WithoutMiddleware;

    /** @test */
    function TOPページを開く()
    {
        $blog1 = Blog::factory()->hasComments(1)->create();
        $blog2 = Blog::factory()->hasComments(3)->create();
        $blog3 = Blog::factory()->hasComments(2)->create();

        $this->get('/')
                ->assertOk()
                ->assertSee($blog1->title)
                ->assertSee($blog2->title)
                ->assertSee($blog3->title)
                ->assertSee($blog1->user->name)
                ->assertSee($blog2->user->name)
                ->assertSee($blog3->user->name)
                ->assertSee("（1件のコメント）")
                ->assertSee("（3件のコメント）")
                ->assertSee("（2件のコメント）")
                ->assertSeeInOrder([$blog2->title, $blog3->title, $blog1->title]);

        /**
         * タイトルの上書き更新も可能
         */
        // $blog1 = Blog::factory()->create(['title' => 'あああ']);
        // $blog2 = Blog::factory()->create(['title' => 'aaaaa']);
        // $blog3 = Blog::factory()->create(['title' => '111111']);

        // $this->get('/')
        //         ->assertOk()
        //         ->assertSee('あああ')
        //         ->assertSee('aaaaa')
        //         ->assertSee('111111');
        
    }
    /** @test */
    function 非公開は表示しない() 
    {
        Blog::factory()->closed()->create([
            'title' => 'ブログA'
        ]);

        Blog::factory()->create(['title' => 'ブログB']);
        Blog::factory()->create(['title' => 'ブログC']);

        $this->get('/')
            ->assertOk()
            ->assertDontSee('ブログA')
            ->assertSee('ブログB')
            ->assertSee('ブログC');
    }

    /** @test */
    // function factoryの監査() 
    // {
    //     // $blog = Blog::factory()->create();
    //     $blog = Blog::factory()->make();
    //     $blog = Blog::factory()->create(['user_id' => 5]);
    //     dump($blog->toArray());
    //     dump(User::get()->toArray());
    // }

    /** @test show */
    function ブログの詳細画面_公開() 
    {
        $this->withoutMiddleware(BlogShowLimit::class);
        $blog = Blog::factory()->create();
        
        $this->get('blogs/'.$blog->id)
            ->assertOK()
            ->assertSee($blog->title)
            ->assertSee($blog->user->name);
    }

    /** @test show */
    function ブログの詳細画面_非公開() 
    {
        $blog = Blog::factory()->closed()->create();

        $this->get('blogs/'.$blog->id)
            ->assertForbidden();
    }

    /** @test */
    function メリークリスマスと表示()
    {
        $this->withoutMiddleware(BlogShowLimit::class);
        $blog = Blog::factory()->create();
        Carbon::setTestNow('2020-12-24');
        $this->get('blogs/'.$blog->id)
            ->assertOK()
            ->assertDontSee('メリークリスマス');

        Carbon::setTestNow('2020-12-25');
        $this->get('blogs/'.$blog->id)
            ->assertOK()
            ->assertSee('メリークリスマス');
    }

    /** @test show */
    function ブログの詳細画面_コメントが古い順に表示される() 
    {

        // ミドルウェアのクラス指定
        $this->withoutMiddleware(BlogShowLimit::class);


        // $blog = Blog::factory()->create();

        // Comment::factory()->create([
        //     'created_at' => now()->sub('2 days'),
        //     'name' => '太郎',
        //     'blog_id' => $blog->id,
        // ]);

        // Comment::factory()->create([
        //     'created_at' => now()->sub('3 days'),
        //     'name' => '二郎',
        //     'blog_id' => $blog->id,
        // ]);

        // Comment::factory()->create([
        //     'created_at' => now()->sub('1 days'),
        //     'name' => '三郎',
        //     'blog_id' => $blog->id,
        // ]);

        $blog = Blog::factory()->withCommentsData([
            ['created_at' => now()->sub('2 days'),'name' => '太郎'],
            ['created_at' => now()->sub('3 days'),'name' => '二郎'],
            ['created_at' => now()->sub('1 days'),'name' => '三郎'],
        ])->create();

        // dd($blog->comments->toarray());
        
        $this->get('blogs/'.$blog->id)
            ->assertOK()
            ->assertSee($blog->title)
            ->assertSee($blog->user->name)
            ->assertSeeInOrder(['二郎','太郎','三郎']);
    }
}
