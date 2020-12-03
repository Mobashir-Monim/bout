<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferedCourse extends Model
{
    use HasFactory;
    use \App\Models\Concerns\UsesUuid;

    protected $guarded = [];

    public function course()
    {
        return $this->belongsTo('App\Models\Course', 'course_id');
    }

    public function sem()
    {
        return $this->belongsTo('App\Models\Run');
    }

    public function sections()
    {
        return $this->hasMany('App\Models\OfferedCourseSection', 'offered_course_id');
    }
}
