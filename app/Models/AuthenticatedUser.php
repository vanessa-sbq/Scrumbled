<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthenticatedUser extends Model
{
    use HasFactory;

    protected $table = 'authenticated_user';

    protected $fillable = [
        'username',
        'hashed_password',
        'full_name',
        'email',
        'bio',
        'picture',
        'status',
        'remember_token',
        'created_at',
    ];

    protected $hidden = [
        'hashed_password',
        'remember_token',
    ];

    public $timestamps = false;
}