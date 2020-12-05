<?php

namespace App\Helpers\CourseEvaluationHelpers;

use App\Helpers\Helper;
use App\Models\CourseEvaluation as CE;

class FactorsHelper extends Helper
{
    public $eval = null;
    public $year = null;
    public $semester = null;

    public function __construct($year, $semester)
    {
        $this->year = $year;
        $this->semester = $semester;
        $this->eval = CE::find($year . "_" . ucfirst($semester));

        if (is_null($this->eval)) {
            $this->eval = CE::create(['id' => $year . "_" . ucfirst($semester)]);
        }
    }

    public function copyFromPrev($year, $semester)
    {
        $prev = CE::find($year . "_" . ucfirst($semester));
        $this->eval->factors = $prev->factors;
        $this->eval->save();
    }

    public function factorsArray()
    {
        return json_decode($this->eval->factors);
    }

    public function getPrevSems()
    {
        return CE::where('id', '!=', $this->eval->id)->where('created_at', '<', $this->eval->created_at)->get();
    }

    public function addFactors($names, $ids, $descs)
    {
        $factors = [];

        foreach ($ids as $key => $id) {
            $factors[$id] = ['name' => $names[$key], 'description' => $descs[$key], 'minVal' => 0, 'maxVal' => 0, 'diff' => 0];
        }

        $this->eval->factors = json_encode($factors);
        $this->eval->save();
    }
}