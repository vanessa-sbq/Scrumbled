<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AuthenticatedUser extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'authenticated_user';

    protected $fillable = [
        'username',
        'password',
        'full_name',
        'email',
        'bio',
        'picture',
        'is_public',
        'status',
        'remember_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the projects where the user is a product owner.
     */
    public function ownedProjects()
    {
        return $this->hasMany(Project::class, 'product_owner_id');
    }

    /**
     * Get the projects where the user is a developer.
     */
    public function developerProjects()
    {
        return $this->belongsToMany(Project::class, 'developer_project', 'developer_id', 'project_id');
    }

    /**
     * Get all projects the user is involved in.
     */
    public function allProjects()
    {
        return $this->ownedProjects->merge($this->developerProjects);
    }

    public function favorites()
    {
        return $this->belongsToMany(Project::class, 'favorite', 'user_id', 'project_id');
    }
    public function profilePic()
    {
        return $this->picture ? asset('storage/' . $this->picture) : asset('images/users/default.png');
    }

    /**
     * Check if the user profile is public.
     *
     * @return bool
     */
    public function isPublic()
    {
        return $this->is_public;
    }

    /**
     * Check if the user is banned.
     *
     * @return bool
     */
    public function isBanned()
    {
        return $this->status === 'BANNED';
    }

    public function isInSameProject(AuthenticatedUser $otherUser)
    {
        $userProjects = $this->ownedProjects->pluck('id')
            ->merge($this->developerProjects->pluck('id'))
            ->unique();

        $otherUserProjects = $otherUser->ownedProjects->pluck('id')
            ->merge($otherUser->developerProjects->pluck('id'))
            ->unique();

        return $userProjects->intersect($otherUserProjects)->isNotEmpty();
    }

}
