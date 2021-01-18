<?php

namespace App\Helpers\OfferedCourseHelpers;

use App\Helpers\Helper;
use App\Models\Course;
use App\Models\OfferedCourse;
use App\Models\OfferedCourseSection;

class Updator extends Helper
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

    public function update($request)
    {
        return $this->type == 'course' ? $this->updateOffered($request) : $this->updateSection($request);
    }

    public function updateCourse($code, $title, $provider, $course)
    {
        $course->code       = $code;
        $course->provider   = $provider;
        $course->title      = $title;
        $course->save();
    }

    public function updateOffered($request)
    {
        $offered = OfferedCourse::find($request->updateData['id']);
        $this->updateCourse($request->updateData['code'], $request->updateData['title'], $request->updateData['provider'], $offered->course);

        $offered->coordinator   = $this->isEmpty($request->updateData['coordinator']);
        $offered->initials      = $this->isEmpty($request->updateData['initials']);
        $offered->email         = $this->isEmpty($request->updateData['email']);
        $offered->has_lab       = $request->updateData['has_lab'];
        $offered->is_lab        = $request->updateData['is_lab'];
        $offered->save();
    }

    public function updateSection($request)
    {
        foreach ($request->updateData['sections'] as $section) {
            $s = OfferedCourseSection::find($section['details']['id']);
            $s->section               = $section['details']['section'];
            $s->name                  = $this->isEmpty($section['details']['name']);
            $s->initials              = $this->isEmpty($section['details']['initials']);
            $s->email                 = $this->isEmpty($section['details']['email']);
            $s->is_lab_faculty        = $section['details']['is_lab_faculty'];
            $s->save();
        }
    }

    public function isEmpty($target)
    {
        if (!is_null($target)) return $target;

        return ' ';
    }
}