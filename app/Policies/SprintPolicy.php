<?php

namespace App\Policies;

use App\Models\AuthenticatedUser;
use App\Models\Sprint;
use Illuminate\Auth\Access\Response;

class SprintPolicy
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
    public function update(AuthenticatedUser $authenticatedUser, Sprint $sprint): bool
    {
        return (($authenticatedUser !== null) && ($sprint !== null));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function close(AuthenticatedUser $authenticatedUser, Sprint $sprint): bool
    {
        return (($authenticatedUser !== null) && ($sprint !== null));
    }
}
