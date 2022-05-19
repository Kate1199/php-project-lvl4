<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\TaskStatus;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $status = TaskStatus::factory()->create();
        $user = User::factory()->create();

        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'status_id' => $status->id,
            'created_by_id' => $user->id,
            'assigned_to_id' => $user->id
        ];
    }
}
