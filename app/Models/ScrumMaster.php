<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScrumMaster extends Model
{
    use HasFactory;

    protected $table = 'scrum_master';

    protected $primaryKey = 'developer_id'; // Specify the primary key

    protected $fillable = [
        'developer_id',
    ];

    public $timestamps = false;

    public $incrementing = false; // Indicate that the primary key is not an incrementing integer

    protected $keyType = 'bigint'; // Specify the type of the primary key

    public function developer()
    {
        return $this->belongsTo(Developer::class, 'developer_id');
    }
}