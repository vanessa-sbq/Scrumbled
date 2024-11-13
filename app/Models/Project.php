<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $table = 'project';

    protected $fillable = [
        'slug',
        'title',
        'description',
        'product_owner_id',
        'scrum_master_id',
        'is_public',
        'is_archived',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    // Define relationships
    public function productOwner()
    {
        return $this->belongsTo(AuthenticatedUser::class, 'product_owner_id');
    }

    public function scrumMaster()
    {
        return $this->belongsTo(AuthenticatedUser::class, 'scrum_master_id');
    }

    /**
     * Get the developers of the project.
     */
    public function developers()
    {
        return $this->belongsToMany(AuthenticatedUser::class, 'developer_project', 'project_id', 'developer_id');
    }
}