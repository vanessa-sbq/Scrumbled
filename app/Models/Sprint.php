<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sprint extends Model
{
    use HasFactory;

    protected $table = 'sprint';

    protected $fillable = [
        'project_id',
        'name',
        'start_date',
        'end_date',
    ];

    public $timestamps = false;

    // Define relationships
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'sprint_id');
    }
}