<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $table = 'favorite';

    protected $primaryKey = ['user_id', 'project_id']; // Specify the composite primary key

    protected $fillable = [
        'user_id',
        'project_id',
    ];

    public $timestamps = false;

    public $incrementing = false; // Indicate that the primary key is not an incrementing integer

    protected $keyType = 'bigint'; // Specify the type of the primary key

    // Define relationships
    public function user()
    {
        return $this->belongsTo(AuthenticatedUser::class, 'user_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}