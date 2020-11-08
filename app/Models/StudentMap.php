<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentMap extends Model
{
    use HasFactory;
    use \App\Models\Concerns\UsesUuid;

    protected $guarded = [];

    public function student()
    {
        return $this->belongsTo('App\Models\Student');
    }
}
