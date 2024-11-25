<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\Project;
use App\Models\Sprint;
use App\Models\Developer;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        // Get the projects and sprints
        $project1 = Project::where('slug', 'scrumbled')->first();
        $project2 = Project::where('slug', 'jira')->first();
        $sprint1 = Sprint::where('name', 'Scrumbled Big Bang')->first();
        $sprint2 = Sprint::where('name', 'Sprint #1')->first();

        // Get the developers
        $joao = Developer::where('user_id', 3)->first();
        $simao = Developer::where('user_id', 4)->first();

        // Create specific tasks
        Task::factory()->create([
            'project_id' => $project1->id,
            'sprint_id' => $sprint1->id,
            'title' => 'Login',
            'description' => 'User Login.',
            'assigned_to' => $joao->user_id,
            'value' => 'MUST_HAVE',
            'state' => 'SPRINT_BACKLOG',
            'effort' => 8,
        ]);

        Task::factory()->create([
            'project_id' => $project2->id,
            'sprint_id' => $sprint2->id,
            'title' => 'Migrate all users',
            'description' => 'Migrate all users from Jira to Scrumbled.',
            'assigned_to' => $simao->user_id,
            'value' => 'MUST_HAVE',
            'state' => 'IN_PROGRESS',
            'effort' => 13,
        ]);

        /*Task::factory()->create([
            'project_id' => $project2->id,
            'sprint_id' => null,
            'title' => 'Delete Database',
            'description' => 'Delete Database after migration.',
            'assigned_to' => null,
            'value' => 'MUST_HAVE',
            'state' => 'BACKLOG',
            'effort' => 13,
        ]);

        Task::factory()->create([
            'project_id' => $project1->id,
            'sprint_id' => $sprint1->id,
            'title' => 'Be better than Jira',
            'description' => 'Title says it all.',
            'assigned_to' => $joao->user_id,
            'value' => 'MUST_HAVE',
            'state' => 'ACCEPTED',
            'effort' => 13,
        ]);*/
    }
}