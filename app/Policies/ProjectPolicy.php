<?php

namespace App\Policies;

use App\Models\AuthenticatedUser;
use App\Models\Project;

class ProjectPolicy
{

    /**
     * Determine whether the user can create models.
     */
    public function create(AuthenticatedUser $user, Project $project): bool
    {
        return (($user !== null) && ($project !== null));
    }

    /**
     * Determine whether the user can manage the project.
     */
    public function manage(AuthenticatedUser $user, Project $project)
    {
        return $user->id === $project->product_owner_id;
    }
}
