<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function タスク一覧取得()
    {
        $tasks = Task::factory(10)->create();
        $response = $this->get('api/tasks');
        // dump($response);
        $response->assertStatus(200);
    }

    /** @test */
    public function タスク詳細取得()
    {
        $tasks = Task::factory(10)->create();
        $response = $this->get('api/tasks/'.$tasks->first()->id);
        // dump($response);
        $response->assertStatus(200);
    }
}
