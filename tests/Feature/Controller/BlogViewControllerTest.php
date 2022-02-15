<?php

namespace Tests\Feature\Controller;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Blog;

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
                ->assertSee($blog3->title);

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
}
