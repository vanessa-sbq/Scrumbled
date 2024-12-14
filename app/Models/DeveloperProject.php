<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeveloperProject extends Model
{
    use HasFactory;

    protected $table = 'developer_project'; // Explicitly set the table name

    protected $fillable = [
        'developer_id',
        'project_id',
        'is_pending',
    ];

    public $timestamps = false; // If `created_at` and `updated_at` are not present

    protected $primaryKey = null; // No single-column primary key
    public $incrementing = false; // Disable auto-incrementing
}