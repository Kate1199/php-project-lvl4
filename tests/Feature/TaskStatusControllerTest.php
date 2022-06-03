<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\TaskStatus;
use App\Models\User;

class TaskStatusControllerTest extends TestCase
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
        $response = $this->get(route('task_statuses.index'));

        $response->assertOk(route('task_statuses.index'));
    }

    public function testCreate(): void
    {
        $response = $this->actingAs($this->user)
                        ->get(route('task_statuses.create'));

        $response->assertOk(route('task_statuses.create'));
    }

    public function testStore(): void
    {
        $taskStatus = TaskStatus::factory()->make(['id' => '4']);
        $response = $this->actingAs($this->user)
                        ->post(route('task_statuses.store'), $taskStatus->toArray());

        $response->assertRedirect(route('task_statuses.index'));

        $this->assertModelExists($taskStatus);
    }

    public function testEdit(): void
    {
        $taskStatus = TaskStatus::first();
        $response = $this->actingAs($this->user)
                        ->get(route('task_statuses.edit', ['task_status' => $taskStatus->id]));

        $response->assertOk(route('task_statuses.edit', ['task_status' => $taskStatus->id]));
    }

    public function testUpdate(): void
    {
        $currentTaskStatus = TaskStatus::first();
        $editedTaskStatus = TaskStatus::factory()->make(['id' => $currentTaskStatus->id]);

        $response = $this->actingAs($this->user)
                        ->patch(route('task_statuses.update', ['task_status' => $currentTaskStatus->id]), $editedTaskStatus->toArray());

        $response->assertRedirect(route('task_statuses.index'));

        $this->assertModelExists($editedTaskStatus);
    }

    public function testDestroy(): void
    {
        $taskStatus = TaskStatus::first();
        $response = $this->actingAs($this->user)
                        ->delete(route('task_statuses.destroy', ['task_status' => $taskStatus->id]));

        $response->assertRedirect(route('task_statuses.index'));

        $this->assertModelMissing($taskStatus);
    }
}
