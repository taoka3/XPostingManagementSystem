<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class XPost extends Model
{
    protected $fillable = [
        'content',
        'images',
        'scheduled_at',
        'status',
        'error_message',
    ];

    protected $casts = [
        'images' => 'array',
        'scheduled_at' => 'datetime',
    ];
}
