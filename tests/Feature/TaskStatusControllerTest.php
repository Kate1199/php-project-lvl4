<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\TaskStatus;
use App\Models\User;

class TaskStatusTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function testIndex(): void
    {
        $response = $this->get(route('task_statuses.index'));

        $response->assertOk();
    }

    public function testCreate(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
                        ->get(route('task_statuses.create'));

        $response->assertOk();
    }

    public function testStore(): void
    {
        $taskStatus = TaskStatus::factory()->create();
        $this->post(route('task_statuses.store'), $taskStatus->toArray());

        $this->assertModelExists($taskStatus);
    }

    public function testEdit(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
                        ->get(route('task_statuses.edit', ['task_status' => 1]));

        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $editedTaskStatus = TaskStatus::factory()->create();

        $this->patch(route('task_statuses.update', ['task_status' => 1], $editedTaskStatus));

        $this->assertModelExists($editedTaskStatus);
    }

    public function testDestroy(): void
    {
        
    }
}
