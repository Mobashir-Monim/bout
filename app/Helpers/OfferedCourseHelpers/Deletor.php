<?php

namespace App\Helpers\OfferedCourseHelpers;

use App\Helpers\Helper;
use App\Models\Course;
use App\Models\OfferedCourse;
use App\Models\OfferedCourseSection;

class Deletor extends Helper
{
    public $year;
    public $semester;
    public $type;
    public $id;

    public function __construct($year, $semester, $type, $id = null)
    {
        $this->year = $year;
        $this->semester = $semester;
        $this->type = $type;
        $this->id = $id;
    }

    public function delete($request)
    {
        if (!is_null($this->id)) {
            $this->targettedDelete($this->id, $this->type);
        } else {
            return $this->type == 'course' ? $this->deleteOffered($request) : $this->deleteSection($request);
        }
    }

    public function deleteOffered($request)
    {
        $offered = OfferedCourse::find($request->deletionData['id']);

        foreach ($offered->sections as $section) {
            $section->delete();
        }

        $offered->delete();
    }

    public function deleteSection($request)
    {
        foreach ($request->deletionData['sections'] as $section) {
            $s = OfferedCourseSection::find($section['id']);
            $s->delete();
        }
    }

    public function targettedDelete($id, $type)
    {
        if ($type == 'course') {
            $this->targettedDeleteCourse($id);
        } elseif ($type == 'offered') {
            $this->targettedDeleteOffered($id);
        } else {
            $section = OfferedCourseSection::find($id);
            $section->delete();
        }
    }

    public function targettedDeleteOffered($id)
    {
        $offered = OfferedCourse::find($id);

        foreach ($offered->sections as $section)
            $section->delete();

        $offered->delete();
    }

    public function targettedDeleteCourse($id)
    {
        $course = Course::find($id);

        foreach ($course->offered as $offered)
            $this->targettedDeleteOffered($offered->id);

        $course->delete();
    }
}