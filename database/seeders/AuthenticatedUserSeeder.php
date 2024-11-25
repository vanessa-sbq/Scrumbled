<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AuthenticatedUser;
use Illuminate\Support\Facades\Hash;

class AuthenticatedUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create specific users
        AuthenticatedUser::factory()->create([
            'username' => 'antonio',
            'password' => Hash::make('password'),
            'full_name' => 'Antonio Abilio',
            'email' => 'up202205469@up.pt',
        ]);

        AuthenticatedUser::factory()->create([
            'username' => 'vanessa',
            'password' => Hash::make('password'),
            'full_name' => 'Vanessa Queiros',
            'email' => 'up202207919@up.pt',
        ]);

        AuthenticatedUser::factory()->create([
            'username' => 'joao',
            'password' => Hash::make('password'),
            'full_name' => 'Joao Santos',
            'email' => 'up202205794@up.pt',
        ]);

        AuthenticatedUser::factory()->create([
            'username' => 'simao',
            'password' => Hash::make('password'),
            'full_name' => 'Simao Neri',
            'email' => 'up202206370@up.pt',
        ]);

    }
}
