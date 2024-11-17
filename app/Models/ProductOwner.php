<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOwner extends Model
{
    use HasFactory;

    protected $table = 'product_owner';

    protected $primaryKey = 'user_id'; // Specify the primary key

    protected $fillable = [
        'user_id',
    ];

    public $timestamps = false;

    public $incrementing = false; // Indicate that the primary key is not an incrementing integer

    protected $keyType = 'bigint'; // Specify the type of the primary key

    public function user()
    {
        return $this->belongsTo(AuthenticatedUser::class, 'user_id');
    }
}