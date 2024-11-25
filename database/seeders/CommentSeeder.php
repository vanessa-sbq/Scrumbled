<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\Task;
use App\Models\AuthenticatedUser;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        // Get the tasks and users
        $task1 = Task::where('title', 'Login')->first();
        $task2 = Task::where('title', 'Migrate all users')->first();
        $antonio = AuthenticatedUser::where('email', 'up202205469@up.pt')->first();
        $vanessa = AuthenticatedUser::where('email', 'up202207919@up.pt')->first();

        // Create specific comments
        Comment::factory()->create([
            'task_id' => $task1->id,
            'user_id' => $antonio->id,
            'description' => 'We can use Jira SSO instead.',
        ]);

        Comment::factory()->create([
            'task_id' => $task2->id,
            'user_id' => $vanessa->id,
            'description' => 'This needs to be done as soon as possible! Our product is irrelevant now.',
        ]);

        // Create random comments for the tasks
        /*Comment::factory()->count(5)->create([
            'task_id' => $task1->id,
            'user_id' => $antonio->id,
        ]);

        Comment::factory()->count(5)->create([
            'task_id' => $task2->id,
            'user_id' => $vanessa->id,
        ]);*/
    }
}