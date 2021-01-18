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

    public function __construct($year, $semester, $type)
    {
        $this->year = $year;
        $this->semester = $semester;
        $this->type = $type;
    }

    public function delete($request)
    {
        return $this->type == 'course' ? $this->deleteOffered($request) : $this->deleteSection($request);
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
}