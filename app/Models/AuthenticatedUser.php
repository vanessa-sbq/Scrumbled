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
        return $this->belongsToMany(Project::class, 'developer_project', 'developer_id', 'project_id')
            ->where('developer_project.is_pending', false);
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
    
    /**
     * Get the notifications for the user.
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
