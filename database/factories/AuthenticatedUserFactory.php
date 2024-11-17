<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AuthenticatedUser>
 */
class AuthenticatedUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'username' => fake()->unique()->userName(),
            'password' => bcrypt('password'),
            'full_name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'bio' => fake()->text(),
            'picture' => fake()->imageUrl(),
            'status' => 'NEEDS_CONFIRMATION',
            'remember_token' => Str::random(10),
        ];
    }
}
