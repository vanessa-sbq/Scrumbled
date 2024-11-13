<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'value' => $this->faker->randomElement(['MUST_HAVE', 'SHOULD_HAVE', 'COULD_HAVE', 'WILL_NOT_HAVE']),
            'state' => $this->faker->randomElement(['BACKLOG', 'SPRINT_BACKLOG', 'IN_PROGRESS', 'DONE', 'ACCEPTED']),
            'effort' => $this->faker->randomElement([1, 2, 3, 5, 8, 13]),
            'created_at' => now(),
        ];
    }
}