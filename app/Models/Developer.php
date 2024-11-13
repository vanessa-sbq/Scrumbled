<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Developer extends Model
{
    use HasFactory;

    protected $table = 'developer';

    protected $fillable = [
        'user_id',
    ];

    public $timestamps = false;

    public $incrementing = false; // Indicate that the primary key is not an incrementing integer

    protected $keyType = 'bigint'; // Specify the type of the primary key

    // Define relationships
    public function user()
    {
        return $this->belongsTo(AuthenticatedUser::class, 'user_id');
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'developer_project')
                    ->withPivot('is_pending')
                    ->withTimestamps();
    }
}