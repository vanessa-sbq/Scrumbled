<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class DeveloperProject extends Pivot
{
    use HasFactory;

    protected $table = 'developer_project';

    protected $fillable = [
        'developer_id',
        'project_id',
        'is_pending',
    ];
}