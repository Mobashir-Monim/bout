<?php

namespace App\Helpers\CourseEvaluationTracker;

use App\Helpers\Helper;
use App\Models\EvalTracker;
use App\Models\OfferedCourseSection as OCS;
use App\Models\OfferedCourse as OC;

class TrackerHelper extends Helper
{
    public $semester;
    public $year;
    protected $tracker_instance;
    public $status;

    public function __construct($semester, $year)
    {
        $this->semester = $semester;
        $this->year = $year;
        $this->tracker_instance = EvalTracker::where('course_evaluation_id', $year . "_" . $semester)->first();
    }

    public function getCourseSections()
    {
        $ocs = OCS::whereIn('offered_course_id', OC::select('id')->where('run_id', $this->year . '_' . $this->semester))->where('email', auth()->user()->email)->get();

        return $ocs;
    }


    public function trackable()
    {
        return !is_null($this->tracker_instance);
    }


    public function setStatusToTrue($message)
    {
        $this->status = [
            'success' => true,
            'error' => false,
            'message' => $message
        ];
    }

    public function setStatusToFalse($message, $error = false)
    {
        $this->status = [
            'success' => false,
            'error' => $error,
            'message' => $message
        ];
    }
}