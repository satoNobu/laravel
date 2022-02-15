<?php

namespace Tests\Feature\Controller;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Blog;
use App\Models\User;

class BlogViewControllerTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    function TOPページを開く()
    {
        $blog1 = Blog::factory()->create();
        $blog2 = Blog::factory()->create();
        $blog3 = Blog::factory()->create();

        $this->get('/')
                ->assertOk()
                ->assertSee($blog1->title)
                ->assertSee($blog2->title)
                ->assertSee($blog3->title)
                ->assertSee($blog1->user->name)
                ->assertSee($blog2->user->name)
                ->assertSee($blog3->user->name);

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
    // function factoryの監査() 
    // {
    //     // $blog = Blog::factory()->create();
    //     $blog = Blog::factory()->make();
    //     $blog = Blog::factory()->create(['user_id' => 5]);
    //     dump($blog->toArray());
    //     dump(User::get()->toArray());
    // }
}
