<?php

namespace App\Helpers\OfferedCourseHelpers;

use App\Helpers\Helper;
use App\Models\Course;
use App\Models\OfferedCourse as OC;
use DB;

class ListHelper extends Helper
{
    protected $list_details;

    public function __construct($list_details = [])
    {
        $this->list_details = $list_details;
    }

    public function compileInstructorDetails($cont, $name_var, $email_var, $include_id = false)
    {
        $details = [
            'name' => $cont->$name_var,
            'email' => $cont->$email_var,
            'initials' => $cont->initials,
            'has_evaluation' => !is_null(json_decode($cont->evaluation))
        ];

        if ($include_id) {
            $details['id'] = $cont->id;
        }

        return $details;
    }

    public function getIndexCourses()
    {
        $courses = $this->getCourses();
        $offerings = [];

        foreach ($courses as $course) {
            $offerings[$course->id] = [];

            foreach ($course->offered as $offered) {
                $offerings[$course->id][$offered->id] = [
                    'run_id' => $offered->run_id,
                    'coordinator' => $this->compileInstructorDetails($offered, 'coordinator', 'email'),
                    'sections' => count($offered->sections),
                    'duplicates' => Course::where('id', '!=', $course->id)
                                        ->where('code', $course->code)
                                        ->where('provider', $course->provider)
                                        ->get()->pluck('id')->toArray()
                ];
            }
        }

        return [
            'courses' => $courses,
            'offerings' => $offerings
        ];
    }

    public function getCourses()
    {
        if (array_key_exists('filter_course', $this->list_details)) {
            if ($this->list_details['filter_course'] != 'duplicates') {
                return Course::where('code', $this->list_details['filter_course'])->orderBy('code')->paginate(20);
            } else {
                $duplicate_sets = DB::select('select code, provider from courses group by code, provider having count(*) >1;');
                $duplicates = [];

                foreach ($duplicate_sets as $set)
                    $duplicates = array_merge($duplicates, Course::where('code', $set->code)->where('provider', $set->provider)->get()->pluck('id')->toArray());

                return Course::whereIn('id', $duplicates)->paginate(20);
            }
        }

        return Course::orderBy('code')->paginate(20);
    }

    public function getOfferedCourseDetails()
    {
        $offered = OC::find($this->list_details['offered_course_id']);
        $details = $this->setOfferedCourseDetails($offered);
        $this->setOfferedCourseSectionsDetails($details, $offered);

        return $details;
    }

    public function setOfferedCourseDetails($offered)
    {
        return [
            'id' => $offered->id,
            'course_id' => $offered->course_id,
            'code' => $offered->course->code,
            'title' => $offered->course->title,
            'provider' => $offered->course->provider,
            'run_id' => $offered->run_id,
            'coordinator' => $this->compileInstructorDetails($offered, 'coordinator', 'email'),
            'sections' => []
        ];
    }

    public function setOfferedCourseSectionsDetails(&$details, $offered)
    {
        foreach ($offered->sections as $section) {
            if (!array_key_exists($section->section, $details['sections'])) {
                $details['sections'][$section->section] = ['theory' => [], 'lab' => []];
            }

            $details['sections'][$section->section][$section->is_lab_faculty ? 'lab' : 'theory'][]
                 = $this->compileInstructorDetails($section, 'name', 'email', true);
        }
    }
}