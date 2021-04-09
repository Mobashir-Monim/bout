<?php

namespace App\Helpers\CourseEvaluationHelpers;

use App\Helpers\Helper;
use App\Models\Course;
use App\Models\CourseEvaluationResult as CER;
use App\Models\OfferedCourse as OC;
use App\Models\OfferedCourseSection as OCS;

class EvaluationCopyHelper extends Helper
{
    protected $offered_source;
    protected $offered_destination;

    public function __construct($course, $source, $destination, $dept, $dept_copy, $course_copy, $section_copy)
    {
        if (!is_null($dept_copy))
            $this->deptCopy($dept, $source, $destination);

        if (!is_null($course)) {
            foreach (Course::where('code', 'like', "$course%")->get() as $course) {
                if (!$this->setOffereds($course, $source, $destination, $course_copy))
                    continue;
    
                if (!is_null($course_copy))
                    $this->copyCourseEvals();
    
                if (!is_null($section_copy))
                    $this->copySectionEvals();
            }
        }
    }

    public function deptCopy($dept, $source, $destination)
    {
        $this->updateSkeleton(
            $dept,
            CER::where('course_evaluation_id', $source)->where('dept', 'skeleton')->first(),
            CER::where('course_evaluation_id', $destination)->where('dept', 'skeleton')->first()
        );

        $this->updateDeptReport(
            CER::where('course_evaluation_id', $source)->where('dept', $dept)->first(),
            CER::where('course_evaluation_id', $destination)->where('dept', $dept)->first(),
            $destination
        );
    }

    public function updateSkeleton($dept, $source, $destination)
    {
        $source_sk = json_decode($source->value, true);
        $destination_sk = json_decode($destination->value, true);
        $destination_sk[$dept] = $source_sk[$dept];
        $destination->value = json_encode($destination_sk);
        $destination->save();
    }

    public function updateDeptReport($source_report, $destination_report, $destination)
    {
        if (!is_null($source_report)) {
            if (is_null($destination_report)) {
                CER::create([
                    'course_evaluation_id' => $destination,
                    'dept' => $source_report->dept,
                    'value' => $source_report->value
                ]);
            } else {
                $destination_report->value = $source_report->value;
                $destination_report->save();
            }
        }
    }

    public function setOffereds($course, $source, $destination, $course_copy)
    {
        $this->offered_source = OC::where('course_id', $course->id)->where('run_id', $source)->first();
        $this->offered_destination = OC::where('course_id', $course->id)->where('run_id', $destination)->first();

        if (is_null($this->offered_source))
            return false;

        if (is_null($this->offered_destination))
            $this->offered_destination = OC::create([
                'course_id' => $course->id,
                'run_id' => $destination,
                'coordinator' => $this->offered_source->coordinator,
                'email' => $this->offered_source->email,
                'initials' => $this->offered_source->initials,
                'bux_code' => $this->offered_source->bux_code,
                'is_lab' => $this->offered_source->is_lab,
                'has_lab' => $this->offered_source->has_lab,
            ]);

        return true;
    }

    public function copyCourseEvals()
    {
        $this->offered_destination->evaluation = '{"links_to":"' . $this->offered_source->id . '"}';
        $this->offered_destination->save();
    }

    public function copySectionEvals()
    {
        foreach (OCS::where('offered_course_id', $this->offered_source->id)->get() as $section_source) {
            $section_destination = OCS::where('offered_course_id', $this->offered_destination->id)->where('section', $section_source->section)->first();

            if (is_null($section_destination)) {
                $this->createOfferedSection($section_source);
            } else {
                $section_destination->evaluation = '{"links_to":"' . $section_source->id . '"}';
                $section_destination->save();
            }
        }
    }

    public function createOfferedSection($section_source)
    {
        OCS::create([
            'offered_course_id' => $this->offered_destination->id,
            'section' => $section_source->section,
            'name' => $section_source->name,
            'initials' => $section_source->initials,
            'email' => $section_source->email,
            'is_lab_faculty' => $section_source->is_lab_faculty,
            'evaluation' => '{"links_to":"' . $section_source->id . '"}'
        ]);
    }
}