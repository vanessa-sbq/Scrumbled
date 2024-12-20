<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notification';

    protected $fillable = [
        'receiver_id',
        'type',
        'project_id',
        'old_product_owner_id',
        'new_product_owner_id',
        'task_id',
        'invited_user_id',
        'completed_by',
        'created_at',
        'is_read'
    ];

    // Define relationships
    public function user()
    {
        return $this->belongsTo(AuthenticatedUser::class, 'user_id');
    }
}