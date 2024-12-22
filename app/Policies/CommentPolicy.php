<?php

namespace App\Policies;

use App\Models\AuthenticatedUser;
use App\Models\Comment;
use App\Models\Task;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(AuthenticatedUser $user, Comment $comment): bool
    {
        return (($user !== null) && ($comment !== null));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(AuthenticatedUser $user, Comment $comment): bool
    {
        return (($user !== null) && ($comment !== null) && ($comment->user_id === $user->id));
    }

}
