<?php

namespace App\Helpers\CourseEvaluationAnalysisHelpers;

use App\Helpers\Helper;
use App\Models\Course;
use App\Models\OfferedCourse as OC;
use App\Models\OfferedCourseSection as OCS;

class SectionsDistribution extends Helper
{
    public $sections = [];
    public $title = '';

    public function __construct($semester, $dept = null, $course = null)
    {
        $this->semester = $semester;
        $this->dept = $dept;
        $this->course = $course;

        if (!is_null($dept)) {
            if (!is_null($course)) {
                $this->getCourseSections();
            } else {
                $this->getDeptSections();
            }
        } else {
            $this->getAllSections();
        }
    }

    public function getAllSections()
    {
        $this->sections = OCS::whereIn(
            'offered_course_id',
            OC::where('run_id', $this->semester)->get()->pluck('id')->toArray()
        )->get(); 
    }

    public function getDeptSections()
    {
        $this->sections = OCS::whereIn(
            'offered_course_id',
            OC::where('run_id', $this->semester)->whereIn(
                'course_id',
                Course::where('provider', $this->dept)->get()->pluck('id')->toArray()
            )->get()->pluck('id')->toArray()
        )->get();
    }

    public function getCourseSections()
    {
        $this->sections = Course::where('provider', $this->dept)->where('code', $this->course)->first()->id;
        $this->sections = OC::where('run_id', $this->semester)->where('course_id', $this->sections)->get()->pluck('id')->toArray();
        $this->sections = OCS::whereIn('offered_course_id', $this->sections)->get();
    }

    public function getLables()
    {
        $labels = [];

        for ($i = 0; $i < 100; $i += 5) { 
            $labels[] = $i . " - " . ($i + 5);
        }

        return $labels;
    }

    public function getCats()
    {
        $labels = $this->getLables();
        $cats = array_fill_keys($labels, []);
        
        foreach ($this->sections as $section) {
            $eval = json_decode($section->evaluation, true);
            if ($eval != null) {
                $temp = array_key_exists('cats', $eval) ? $eval['cats'] :
                    json_decode(OCS::find($eval['links_to'])->evaluation, true)['cats'];

                foreach ($temp as $cat => $value) {
                    $val_class = (int) ($value / 5);
                    $val_class = $val_class == 20 ? 19 : $val_class;

                    if (!array_key_exists($cat, $cats[$labels[$val_class]])) {
                        $cats[$labels[$val_class]][$cat] = 0;
                    }

                    $cats[$labels[$val_class]][$cat] += 1;
                }
            }
        }

        return $cats;
    }
}