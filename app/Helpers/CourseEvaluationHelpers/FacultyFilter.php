<?php

namespace App\Helpers\CourseEvaluationHelpers;

use App\Helpers\Helper;
use App\Models\Course;
use App\Models\OfferedCourse as OC;
use App\Models\OfferedCourseSection as OCS;

class FacultyFilter extends Helper
{
    public $year;
    public $semester;
    public $results;

    public function __construct($year, $semester, $search_phrase)
    {
        $this->year = $year;
        $this->semester = $semester;

        $this->searchFaculty(
            $this->getAccessibleCourses($year, $semester),
            $search_phrase
        );

        $this->formatResults();
    }

    public function getAccessibleCourses()
    {
        $helper = new ReportHelper($this->year, $this->semester, true);
        $departments = array_keys(json_decode(json_encode($helper->results), true));
        
        return OC::whereIn(
            'course_id',
            Course::whereIn(
                'provider',
                $departments
            )->get()->pluck('id')->toArray()
        )->where('run_id', $this->year . '_' . ucfirst($this->semester))
        ->get()->pluck('id')->toArray();

    }

    public function searchFaculty($courses, $search_phrase)
    {
        $this->results = OCS::whereIn(
            'offered_course_id',
            $courses
        )->where('name', 'like', "%$search_phrase%")->get();

        $this->results = $this->results->merge(OCS::whereIn(
            'offered_course_id',
            $courses
        )->where('email', 'like', "%$search_phrase%")->get());

        // $this->results = $this->results->unique();
    }

    public function formatResults()
    {
        $formatted = [];

        foreach ($this->results as $result) {
            if (!array_key_exists($result->email, $formatted))
                $formatted[$result->email] = [
                    'name' => $result->name,
                    'reports' => []
                ];

            $formatted[$result->email]['reports'][] = $this->buildResultItem($result);
        }

        $this->results = $formatted;
    }

    public function buildResultItem($result)
    {
        $details = $result->sectionDetails;
        $shell = [
            'title' => $details['code'] . " - Section " . $details['section'],
            'link' => [
                'year' => $this->year,
                'semester' => $this->semester,
                'department' => $details['dept'],
                'course' => $details['code'],
                'section' => $details['section'],
            ]
        ];

        if ($details['is_lab']) {
            return [
                'title' => $shell['title'] . " (lab)",
                'link' => route('eval-report.lab', $shell['link'])
            ];
        } else {
            return [
                'title' => $shell['title'],
                'link' => route('eval-report.section', $shell['link'])
            ];
        }
    }
}