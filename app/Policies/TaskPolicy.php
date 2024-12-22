<?php

namespace App\Policies;

use App\Models\AuthenticatedUser;
use App\Models\Task;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(AuthenticatedUser $authenticatedUser): bool
    {
        return ($authenticatedUser !== null);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(AuthenticatedUser $authenticatedUser, Task $task): bool
    {
        return (($authenticatedUser !== null) && ($task !== null));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(AuthenticatedUser $authenticatedUser, Task $task): bool
    {
        return (($authenticatedUser !== null) && ($task !== null));
    }
}
