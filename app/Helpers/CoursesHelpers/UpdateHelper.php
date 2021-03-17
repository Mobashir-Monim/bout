<?php

namespace App\Helpers\CoursesHelpers;

use App\Helpers\Helper;
use App\Models\EnterprisePart;
use App\Models\Course;
use App\Models\OfferedCourse;

class UpdateHelper extends Helper
{
    protected $course;
    protected $code;
    protected $title;
    protected $provider;
    protected $update_type;

    public function __construct($course, $code, $title, $provider)
    {
        $this->course = $course;
        $this->code = $code;
        $this->title = $title;
        $this->provider = $provider;
        $this->setUpdateType();
    }

    public function setUpdateType()
    {
        $update_type['conflict_resolve'] = false;
        
        if ($this->course->provider != $this->provider)
            $update_type['conflict_resolve'] = !is_null(Course::where('provider', $this->course->provider)->where('code', $this->course->code)->first())
                                            && !is_null(Course::where('provider', $this->provider)->where('code', $this->course->code)->first());

        $this->update_type = $update_type;
    }

    public function update()
    {
        if ($this->update_type['conflict_resolve']) $this->resolveConflict();
        $this->course->code = $this->code;
        $this->course->title = $this->title;
        $this->course->provider = $this->provider;
        $this->course->save();
    }

    public function resolveConflict()
    {
        $resolve_id = Course::where('provider', $this->provider)->where('code', $this->course->code)->first()->id;

        foreach (OfferedCourse::where('course_id', $resolve_id)->get() as $offered) {
            $offered->course_id = $resolve_id;
            $offered->save();
        }

        $duplicate = Course::where('provider', $this->course->provider)->where('code', $this->course->code)->first();
        
        if ($duplicate->id != $resolve_id) {
            $duplicate->delete();
        }
    }
}