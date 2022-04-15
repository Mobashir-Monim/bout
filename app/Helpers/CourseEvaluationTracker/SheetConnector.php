<?php

namespace App\Helpers\CourseEvaluationTracker;

use App\Helpers\Helper;
use App\Models\EvalTracker;

class SheetConnector extends Helper
{
    private $spread_sheet_id;
    private $client;
    private $sheetService;

    public function __construct($course_evaluation_id)
    {
        $tracker = EvalTracker::where('course_evaluation_id', $course_evaluation_id)->first();
        // $this->spread_sheet_id = ;
    }
}