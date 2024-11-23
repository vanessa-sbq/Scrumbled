<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'task';

    protected $fillable = [
        'project_id',
        'sprint_id',
        'title',
        'description',
        'assigned_to',
        'value',
        'state',
        'effort',
    ];

    // Define relationships
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function sprint()
    {
        return $this->belongsTo(Sprint::class, 'sprint_id');
    }

    public function assignedDeveloper()
    {
        return $this->belongsTo(Developer::class, 'assigned_to', 'user_id');
    }
}
