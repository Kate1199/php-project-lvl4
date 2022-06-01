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
    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->user = User::factory()->create();
    }

    public function testIndex(): void
    {
        $response = $this->get(route('tasks.index'));

        $response->assertOk(route('tasks.index'));
    }

    public function testCreate(): void
    {
        $response = $this->actingAs($this->user)
                        ->get(route('tasks.create'));

        $response->assertOk(route('tasks.create'));
    }

    public function testStore(): void
    {
        $taskStatus = Task::factory()->make(['id' => '4']);
        $response = $this->actingAs($this->user)
                        ->post(route('tasks.store'), $taskStatus->toArray());

        $response->assertRedirect(route('tasks.index'));

        $this->assertModelExists($taskStatus);
    }

    public function testEdit(): void
    {
        $task = Task::first();
        $response = $this->actingAs($this->user)
                        ->get(route('tasks.edit', ['task' => $task->id]));

        $response->assertOk(route('tasks.edit', ['task' => $task->id]));
    }

    public function testUpdate(): void
    {
        $task = Task::first();
        $editedTask = Task::factory()->make(['id' => $task->id]);

        $response = $this->actingAs($this->user)
                        ->patch(route('tasks.update', ['task' => $task->id]), $editedTask->toArray());

        $response->assertRedirect(route('tasks.index'));

        $this->assertModelExists($editedTask);
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
