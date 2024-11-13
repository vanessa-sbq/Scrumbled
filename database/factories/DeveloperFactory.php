<?php

namespace Database\Factories;

use App\Models\Developer;
use App\Models\AuthenticatedUser;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeveloperFactory extends Factory
{
    protected $model = Developer::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => AuthenticatedUser::factory(),
        ];
    }
}