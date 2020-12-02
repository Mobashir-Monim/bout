<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    use \App\Models\Concerns\UsesUuid;

    protected $guarded = [];

    public function offered()
    {
        return $this->hasMany('App\Models\OfferedCourse');
    }

    
}
