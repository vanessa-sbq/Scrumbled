<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sprint;
use App\Models\Project;

class SprintSeeder extends Seeder
{
    public function run(): void
    {
        // Get the projects
        $project1 = Project::where('slug', 'scrumbled')->first();
        $project2 = Project::where('slug', 'jira')->first();

        // Create sprints and associate them with the projects
        Sprint::create([
            'project_id' => $project1->id,
            'name' => 'Scrumbled Big Bang',
            'start_date' => now(),
            'end_date' => now()->addMonth(),
            'is_archived' => false
        ]);

        Sprint::create([
            'project_id' => $project2->id,
            'name' => 'Sprint #1',
            'start_date' => now(),
            'end_date' => now()->addMonth(),
            'is_archived' => false
        ]);
    }
}