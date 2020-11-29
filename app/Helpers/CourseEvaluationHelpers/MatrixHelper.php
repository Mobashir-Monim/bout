<?php

namespace App\Helpers\CourseEvaluationHelpers;

use App\Helpers\Helper;
use App\Models\CourseEvaluation as CE;
use App\Models\CourseEvaluationMatrix as CEM;

class MatrixHelper extends Helper
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

    public function questionMatrix()
    {
        $matrix = '';

        foreach ($this->eval->matrices->sortBy('part') as $key => $m) {
            $matrix .= $m->value;
        }

        return $matrix == '' ? [] : json_decode($matrix);
    }

    public function getUniqueFactors($question)
    {
        $unique = [];

        foreach ($question->options as $factors) {
            foreach ($factors as $factor => $value) {
                if (!in_array($factor, $unique))
                    array_push($unique, $factor);
            }
        }

        return $unique;
    }

    public function storeMatrix($parts, $index)
    {
        if ($index == 0) {
            $this->pruneMatrix();
        }

        foreach ($parts as $key => $part) {
            CEM::create([
                'course_evaluation_id' => $this->eval->id,
                'part' => $key + $index,
                'value' => $part
            ]);
        }
    }

    public function pruneMatrix()
    {
        foreach ($this->eval->matrices as $part) {
            $part->delete();
        }
    }
}