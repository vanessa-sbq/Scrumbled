<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AuthenticatedUser;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        // Get the hardcoded users
        $antonio = AuthenticatedUser::where('email', 'up202205469@up.pt')->first();
        $vanessa = AuthenticatedUser::where('email', 'up202207919@up.pt')->first();
        $joao = AuthenticatedUser::where('email', 'up202205794@up.pt')->first();
        $simao = AuthenticatedUser::where('email', 'up202206370@up.pt')->first();

        // Create projects and associate them with the hardcoded users
        Project::create([
            'slug' => 'scrumbled',
            'title' => 'Scrumbled',
            'description' => 'Lbaw project',
            'product_owner_id' => $antonio->id,
            'scrum_master_id' => $simao->id,
            'is_public' => true,
            'is_archived' => false,
            'created_at' => now(),
        ]);

        Project::create([
            'slug' => 'jira',
            'title' => 'Jira',
            'description' => 'Copy of Scrumbled',
            'product_owner_id' => $vanessa->id,
            'scrum_master_id' => $joao->id,
            'is_public' => false,
            'is_archived' => false,
            'created_at' => now(),
        ]);
    }
}
