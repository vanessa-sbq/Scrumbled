<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::factory()->create([
            'email' => 'up202207919@up.pt',
            'password'=> Hash::make('password'),
        ]);

        Admin::factory()->create([
            'email' => 'admin@email.com',
            'password'=> Hash::make('password'),
        ]);
    }
}
