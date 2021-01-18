<?php

namespace App\Helpers\OfferedCourseHelpers;

use App\Helpers\Helper;
use App\Models\Course;
use App\Models\OfferedCourse;
use App\Models\OfferedCourseSection;

class Creator extends Helper
{
    public $year;
    public $semester;
    public $type;

    public function __construct($year, $semester, $type)
    {
        $this->year = $year;
        $this->semester = $semester;
        $this->type = $type;
    }

    public function getCourse($code, $title, $provider)
    {
        $course = Course::where('provider', $provider)->where('code', $code)->first();
        
        if (is_null($course)) {
            $course = Course::create(['provider' => $provider, 'code' => $code, 'title' => $title]);
        }

        return $course;
    }

    public function create($request)
    {
        return $this->type == 'course' ? $this->createOffered($request) : $this->createSection($request);
    }

    public function createOffered($request)
    {
        $offered = OfferedCourse::create([
            'course_id'     => $this->getCourse($request->creationData['code'], $request->creationData['title'], $request->creationData['provider'])->id,
            'coordinator'   => $this->isEmpty($request->creationData['coordinator']),
            'initials'      => $this->isEmpty($request->creationData['initials']),
            'email'         => $this->isEmpty($request->creationData['email']),
            'run_id'        => $this->year . "_" . ucfirst($this->semester),
            'has_lab'       => $request->creationData['has_lab'],
            'is_lab'        => $request->creationData['is_lab'],
        ]);

        return $offered->id;
    }

    public function createSection($request)
    {
        $sids = [];

        foreach ($request->creationData['sections'] as $section) {
            $s = OfferedCourseSection::create([
                'offered_course_id' => $request->creationData['offered_id'],
                'section'           => $section['details']['section'],
                'name'              => $this->isEmpty($section['details']['name']),
                'initials'          => $this->isEmpty($section['details']['initials']),
                'email'             => $this->isEmpty($section['details']['email']),
                'is_lab_faculty'    => $section['details']['is_lab_faculty'],
            ]);

            $sids[] = $s->id;
        }

        return $sids;
    }

    public function isEmpty($target)
    {
        if (!is_null($target)) return $target;

        return ' ';
    }
}