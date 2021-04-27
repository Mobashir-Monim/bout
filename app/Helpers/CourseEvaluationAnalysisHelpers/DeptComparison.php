<?php

namespace App\Helpers\CourseEvaluationAnalysisHelpers;

use App\Helpers\Helper;
use App\Models\CourseEvaluationResult as CER;
use App\Models\CourseEvaluation as CE;

class DeptComparison extends Helper
{
    protected $cer;
    public $title = 'Department Scores Comparison';

    public function __construct($semester)
    {
        $this->cer = CER::where('course_evaluation_id', $semester)->where('dept', '!=', 'skeleton')->get();
    }

    public function getLables()
    {
        return $this->cer->pluck('dept')->toArray();
    }

    public function getCats()
    {
        $cats = [];

        foreach ($this->cer as $cer_part)
            $cats[$cer_part->dept] = json_decode($cer_part->value, true)['cats'];

        return $cats;
    }
}