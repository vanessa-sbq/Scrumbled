<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AuthenticatedUser;
use App\Models\Project;
use App\Models\DeveloperProject;
use App\Models\Favorite;

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
        $project1 = Project::factory()->create([
            'slug' => 'scrumbled',
            'title' => 'Scrumbled',
            'description' => 'Lbaw project',
            'product_owner_id' => $antonio->id,
            'scrum_master_id' => $simao->id,
            'is_public' => true,
            'is_archived' => false,
        ]);

        $project2 = Project::factory()->create([
            'slug' => 'jira',
            'title' => 'Jira',
            'description' => 'Copy of Scrumbled',
            'product_owner_id' => $vanessa->id,
            'scrum_master_id' => $joao->id,
            'is_public' => false,
            'is_archived' => false,
        ]);

        // Add developers to projects
        DeveloperProject::create([
            'developer_id' => $joao->id,
            'project_id' => $project1->id,
            'is_pending' => false,
        ]);

        DeveloperProject::create([
            'developer_id' => $joao->id,
            'project_id' => $project2->id,
            'is_pending' => false,
        ]);

        DeveloperProject::create([
            'developer_id' => $simao->id,
            'project_id' => $project1->id,
            'is_pending' => true,
        ]);

        DeveloperProject::create([
            'developer_id' => $simao->id,
            'project_id' => $project2->id,
            'is_pending' => false,
        ]);

        // Add favorites
        Favorite::create([
            'user_id' => $antonio->id,
            'project_id' => $project1->id,
        ]);

        Favorite::create([
            'user_id' => $joao->id,
            'project_id' => $project2->id,
        ]);
    }
}