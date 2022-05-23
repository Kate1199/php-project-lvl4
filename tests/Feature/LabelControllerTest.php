<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LabelControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::serUp();
        $this->seed();
    }

    public function testIndex()
    {
        $response = $this->get(route('labels.index'));

        $response->assertOk();
    }

    public function testCreate(): void
    {
        $response = $this->get(route('labels.create'));

        $response->assertOk();
    }

    public function testStore(): void
    {
        $label = Label::factory()->make();
        $this->post(route('labels.store', $label));

        $this->assertDatabaseHas($label);
    }

    public function testEdit(): void
    {
        $response = $this->get(route('labels.edit', 1));

        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $label = Label::factory()->make();
        $this->patch(route('labels.update', ['label' => 1]), $label);

        $this->assertDatabaseHas($label);
    }

    public function testDestroy(): void
    {
        $label = Labels::first();
        $this->delete(route('labels.destroy', ['label' => $label->id]));

        $this->assertModelMissing($label);
    }
}
