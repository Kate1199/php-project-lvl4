<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use App\Models\TaskStatus;
use Database\Seeders\UserSeeder;
use Database\Seeders\TaskStatusSeeder;
use Database\Seeders\TaskSeeder;

class TaskControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function testIndex(): void
    {
        $response = $this->get(route('tasks.index'));

        $response->assertOk();
    }

    public function testCreate(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
                        ->get(route('tasks.create'));

        $response->assertOk();
    }

    public function testStore(): void
    {
        $taskStatus = Task::factory()->create();
        $this->post(route('tasks.store'), $taskStatus->toArray());

        $this->assertModelExists($taskStatus);
    }

    public function testEdit(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
                        ->get(route('tasks.edit', ['task' => 1]));

        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $editedTaskStatus = Task::factory()->create();

        $this->patch(route('tasks.update', ['task' => 1], $editedTaskStatus));

        $this->assertModelExists($editedTaskStatus);
    }

    public function testDestroy(): void
    {
        $task = Task::first();
        $created_by_id = $task->created_by_id;

        $user = User::factory()->make([
            'id' => $created_by_id
        ]);

        $this->actingAs($user)
                ->delete(route('tasks.destroy', ['task' => $task->id]));

        $this->assertModelMissing($task);
    }
}
