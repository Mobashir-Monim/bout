<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferedCourseSection extends Model
{
    use HasFactory;
    use \App\Models\Concerns\UsesUuid;

    public function sectionOf()
    {
        return $this->belongsTo('App\Models\OfferedCourse', 'offered_course_id');
    }

    public function getSectionDetailsAttribute()
    {
        $offered = $this->sectionOf;
        $course = $offered->course;

        return [
            'dept' => $course->provider,
            'code' => $course->code,
            'title' => $course->title,
            'run' => $offered->run_id,
            'section' => $this->attributes['section'],
            'is_lab' => $this->attributes['is_lab_faculty'],
        ];
    }
}
