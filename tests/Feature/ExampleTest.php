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

    /** @test */
    public function タスク登録()
    {
        $task = [
            'title' => 'Test_Title',
            'content' => 'Test_Content',
            'person_in_charge' => 'Test_Person_in_charge',
        ];
        $response = $this->post('api/tasks/', $task)
            ->assertCreated();
        $this->assertCount(1, Task::all());
    }

    /** @test */
    public function タスク更新()
    {
        $tasks = Task::factory(1)->create();
        $task = [
            'title' => 'update',
        ];
        $response = $this->put('api/tasks/'.$tasks->first()->id, $task)
            ->assertOk();
        $this->assertCount(1, Task::all());

        $this->assertEquals('update', $tasks->fresh()->first()->title);
    }

    /** @test */
    public function タスク削除()
    {
        $tasks = Task::factory(1)->create();

        $response = $this->delete('api/tasks/'.$tasks->first()->id)
            ->assertOk();
        $this->assertCount(0, Task::all());
    }
}
