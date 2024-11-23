<?php

namespace App\Policies;

use App\Models\AuthenticatedUser;
use App\Models\Project;
use App\Models\Sprint;
use App\Models\Task;
use Illuminate\Auth\Access\Response;

class ProjectPolicy
{
    /**
     * Summary of manage
     * @param \App\Models\AuthenticatedUser $user
     * @param \App\Models\Project $project
     * @return bool
     */
    public function manage(AuthenticatedUser $user, Project $project)
    {
        return $user->id === $project->product_owner_id;
    }

    /**
     * Determine if the given sprint can be managed by the user.
     *
     * @param  \App\Models\AuthenticatedUser  $user
     * @param  \App\Models\Sprint  $sprint
     * @return bool
     */
    public function manageSprint(AuthenticatedUser $user, Sprint $sprint)
    {
        return $user->id === $sprint->project->product_owner_id;
    }

    /**
     * Determine if the given task can be managed by the user.
     *
     * @param  \App\Models\AuthenticatedUser  $user
     * @param  \App\Models\Task  $task
     * @return bool
     */
    public function manageTask(AuthenticatedUser $user, Task $task)
    {
        return $user->id === $task->project->product_owner_id;
    }
}
