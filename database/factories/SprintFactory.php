<?php

namespace Database\Factories;

use App\Models\Sprint;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class SprintFactory extends Factory
{
    protected $model = Sprint::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_id' => Project::factory(),
            'name' => $this->faker->words(3, true),
            'start_date' => now(),
            'end_date' => now()->addMonth(),
            'is_archived' => false
        ];
    }
}