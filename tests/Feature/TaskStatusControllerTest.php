<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskStatusTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function testCreate(): void
    {
        $response = $this->get(route('task_statuses.create'));

        $response->assertOk();
    }

    public function testStore(): void
    {
        $taskStatus = TaskStatus::factory()->make();

        $this->post(route('task_statuses.store'), $taskStatus);

        $this->assertDatabaseHas('task_statuses', $taskStatus);
    }

    public function testShow(): void
    {
        $response1 = $this->get(route('task_statuses.show', ['task_status' => 1]));
        $response1->assertOk();

        $response2 = $this->get(route('task_statuses.show', ['task_status' => 2]));
        $response2->assertOk();

        $response3 = $this->get(route('task_statuses.show', ['task_status' => 3]));
        $response3->assertOk();
    }

    public function testEdit(): void
    {
        $response = $this->get(route('task_statuses.edit', ['task_status' => 1]));

        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $editedTaskStatus = TaskStauts::factory()->make();

        $this->patch(route('task_statuses.update', ['task_status' => 1]), $editedTaskStatus);

        $this->assertDatabaseHas('task_statuses', $editedTaskStatus);
    }

    public function testDestroy(): void
    {
        
    }
}
