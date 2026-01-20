<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminKey extends Model
{
    protected $fillable = [
        'key',
        'name',
    ];
}
