<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Label;
use App\Models\User;
use Faker\Factory;
use Illuminate\Support\Carbon;

class LabelControllerTest extends TestCase
{
    private $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->user = User::factory()->create();
    }

    public function testIndex()
    {
        $response = $this->get(route('labels.index'));

        $response->assertOk(route('labels.index'));
    }

    public function testCreate(): void
    {
        $response = $this->actingAs($this->user)
                        ->get(route('labels.create'));

        $response->assertOk(route('labels.create'));
    }

    public function testStore(): void
    {
        $label = Label::factory()->make();
        $response = $this->actingAs($this->user)
            ->post(route('labels.store'), $label->toArray());

        $response->assertRedirect(route('labels.index'));

        $this->assertDatabaseHas('labels', $label->toArray());
    }

    public function testEdit(): void
    {
        $label = Label::first();
        $response = $this->actingAs($this->user)
                        ->get(route('labels.edit', ['label' => $label->id]));

        $response->assertOk(route('labels.edit', ['label' => $label->id]));
    }

    public function testUpdate(): void
    {
        $faker = Factory::create();
        $name = $faker->word();

        $label = Label::first();
        $label->name = $name;

        $response = $this->actingAs($this->user)
            ->patch(route('labels.update', ['label' => $label->id]), ['name' => $name]);

        $response->assertRedirect(route('labels.index'));

        $this->assertDatabaseHas('labels', [
            'id' => $label->id,
            'name' => $label->name,
            'description' => $label->description
        ]);
    }

    public function testDestroy(): void
    {
        $label = Label::first();

        $response = $this->actingAs($this->user)
            ->delete(route('labels.destroy', ['label' => $label->id]));

        $response->assertRedirect(route('labels.index'));

        $this->assertModelMissing($label);
    }
}
