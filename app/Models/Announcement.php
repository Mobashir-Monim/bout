<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;
    use \App\Models\Concerns\UsesUuid;

    protected $guarded = [];
    protected $casts = [
        'keywords' => 'array',
        'enterprise_parts' => 'array',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
