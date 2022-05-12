<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function testIndex(): void
    {
        $response = $this->get(route('task.index'));

        $response->assertOk();
    }

    public function testCreate(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
                        ->get(route('task.create'));

        $response->assertOk();
    }

    public function testStore(): void
    {
        $taskStatus = Task::factory()->create();
        $this->post(route('task.store'), $taskStatus->toArray());

        $this->assertModelExists($taskStatus);
    }

    public function testEdit(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
                        ->get(route('task.edit', ['task' => 1]));

        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $editedTaskStatus = Task::factory()->create();

        $this->patch(route('task.update', ['task' => 1], $editedTaskStatus));

        $this->assertModelExists($editedTaskStatus);
    }

    public function testDestroy(): void
    {
        $task = $this->delete(route('task.destroy', ['task' => 1]));

        $this->assertModelMissing($task);
    }
}
