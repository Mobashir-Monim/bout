<?php

namespace App\Helpers\CourseEvaluationHelpers;

use App\Helpers\Helper;
use App\Models\CourseEvaluation as CE;
use App\Models\CourseEvaluationMatrix as CEM;

class EvaluationHelper extends Helper
{
    public $eval = null;
    public $year = null;
    public $semester = null;

    public function __construct($year, $semester)
    {
        $this->year = $year;
        $this->semester = $semester;
        $this->eval = CE::find("$year-$semester");

        if (is_null($this->eval)) {
            $this->eval = CE::create(['id' => "$year-$semester"]);
        }
    }
}