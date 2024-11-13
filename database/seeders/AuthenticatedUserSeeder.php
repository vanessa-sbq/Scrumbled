<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthenticatedUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AuthenticatedUser::factory()->create([
            'username' => 'antonio',
            'hashed_password' => Hash::make('password'),
            'full_name' => 'Antonio Abilio',
            'email' => 'up202205469@up.pt',
        ]);

        AuthenticatedUser::factory()->create([
            'username' => 'vanessa',
            'hashed_password' => Hash::make('password'),
            'full_name' => 'Vanessa Queiros',
            'email' => 'up202207919@up.pt',
        ]);

        AuthenticatedUser::factory()->create([
            'username' => 'joao',
            'hashed_password' => Hash::make('password'),
            'full_name' => 'Joao Santos',
            'email' => 'up202205794@up.pt',
        ]);

        AuthenticatedUser::factory()->create([
            'username' => 'simao',
            'hashed_password' => Hash::make('password'),
            'full_name' => 'Simao Neri',
            'email' => 'up202206370@up.pt',
        ]);
    }
}
