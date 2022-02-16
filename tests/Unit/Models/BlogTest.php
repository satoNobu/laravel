<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use App\Models\Blog;
use App\Models\User;
use GuzzleHttp\Promise\Create;

class BlogTest extends TestCase
{
    use RefreshDatabase;
    /**  @test */
    public function Userのリレーションを返す()
    {
        $blog = Blog::factory()->create();
        $this->assertInstanceOf(User::class, $blog->user);
    }

    /**  @test */
    public function Commentのリレーションを返す()
    {
        $blog = Blog::factory()->create();
        $this->assertInstanceOf(Collection::class, $blog->comments);
    }

    /** @test */
    public function ブログのscope()
    {
        $blog1 = Blog::factory()->create([
            'status' => Blog::CLOSED,
            'title' => 'ブログA'
        ]);

        $blog2 = Blog::factory()->create(['title' => 'ブログB']);
        $blog3 = Blog::factory()->create(['title' => 'ブログC']);

        $blogs = Blog::onlyOpen()->get();
        // dump($blogs->toArray());

        $this->assertFalse($blogs->contains($blog1));
        $this->assertTrue($blogs->contains($blog2));
        $this->assertTrue($blogs->contains($blog3));
    }

    /** @test */
    public function 公開_非公開()
    {
        $blog = Blog::factory()->closed()->create();
        // $blog = Blog::factory()->closed()->make();
        $this->assertTrue($blog->isClosed());

        $blog = Blog::factory()->create();
        $this->assertFalse($blog->isClosed());
    }
 
}
