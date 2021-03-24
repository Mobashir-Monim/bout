<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $guarded = [];
    protected $casts = [
        'configs' => 'array',
        'id' => 'string',
    ];
}
