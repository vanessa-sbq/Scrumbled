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
}
