<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->words(3, true); // Generate a project name with 3 words
        return [
            'slug' => Str::slug($title),
            'title' => $title,
            'description' => $this->faker->paragraph,
            'product_owner_id' => null, // This will be set in the seeder
            'scrum_master_id' => null, // This will be set in the seeder
            'is_public' => $this->faker->boolean,
            'is_archived' => $this->faker->boolean,
            'created_at' => now(),
        ];
    }
}