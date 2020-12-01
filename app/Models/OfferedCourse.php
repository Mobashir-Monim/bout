<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferedCourse extends Model
{
    use HasFactory;
    use \App\Models\Concerns\UsesUuid;

    public function course()
    {
        return $this->belongsTo('App\Models\Course');
    }

    public function sem()
    {
        return $this->belongsTo('App\Models\Run');
    }

    public function section()
    {
        return $this->hasMany('App\Models\OfferedCourseSection');
    }
}
