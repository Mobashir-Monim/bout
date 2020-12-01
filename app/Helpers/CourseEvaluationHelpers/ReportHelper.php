<?php

namespace App\Helpers\CourseEvaluationHelpers;

use App\Helpers\Helper;
use App\Models\CourseEvaluation as CE;

class ReportHelper extends Helper
{
    public $eval = null;
    public $type = null;
    public $specs = null;
    public $year = null;
    public $semester = null;
    public $data = null;

    public function __construct($year, $semester)
    {
        $this->year = $year;
        $this->semester = $semester;
        $this->eval = CE::find("$year-$semester");
    }

    public function getData()
    {
        $results = $this->eval->compiledResults;

        if ($type = 'dept') {
            return $results->$specs['dept'];
        }
    }
}