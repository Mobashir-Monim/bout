<?php

namespace App\Helpers\CourseEvaluationHelpers;

use App\Helpers\Helper;
use App\Models\CourseEvaluation as CE;
use App\Models\CourseEvaluationResult as CER;

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

    public function storeResults($parts, $index)
    {
        if ($index == 0) {
            $this->pruneResults();
        }

        foreach ($parts as $key => $part) {
            CER::create([
                'course_evaluation_id' => $this->eval->id,
                'part' => $key + $index,
                'value' => $part
            ]);
        }
    }

    public function pruneResults()
    {
        foreach ($this->eval->results as $part) {
            $part->delete();
        }
    }
}