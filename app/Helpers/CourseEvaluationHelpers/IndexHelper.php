<?php

namespace App\Helpers\CourseEvaluationHelpers;

use App\Helpers\Helper;

class IndexHelper extends Helper
{
    public function semesterConfirm($semester, $year)
    {
        return [
            'results' => [
                'parts' => [
                    [
                        'type' => 'message',
                        'title' => 'Evaluation Results are not available'
                    ],
                ]
            ],
            'config-factors' => canConfigFactors(),
            'config-matrix' => canConfigMatrix(),
            'evaluate' => canEvaluate(),
            'publish' => canPublish(),
        ];
        $semester_confirm_results = ['semester' => true, 'results' => true, 'config' => true];
        
    }

    public function resultsAvailable()
    {
        if ($year < 2020 || ($year == 2020 && $semester == 'spring')) {
            return nullResults();
        }

        $eval = CourseEvaluation::find($year . "_" . ucfirst($semester));

        if (is_null($eval)) {
            return nullResults();
        }

        if (!$eval->is_published) {
            return nullResults();
        }

        return buildResultParts();
    }

    public function canConfigFactors()
    {
        return auth()->user()->email == 'mobashir.monim@bracu.ac.bd' || auth()->user()->email == 'ext.mobashir.monim@bracu.ac.bd';
    }
    
    public function canConfigMatrix()
    {
        return auth()->user()->email == 'mobashir.monim@bracu.ac.bd' || auth()->user()->email == 'ext.mobashir.monim@bracu.ac.bd';
    }

    public function canEvaluate()
    {
        return auth()->user()->email == 'mobashir.monim@bracu.ac.bd' || auth()->user()->email == 'ext.mobashir.monim@bracu.ac.bd';
    }

    public function canPublish()
    {
        return auth()->user()->email == 'mobashir.monim@bracu.ac.bd' || auth()->user()->email == 'ext.mobashir.monim@bracu.ac.bd';
    }

    public function nullResults()
    {
        return [
            'success' => false,
            'title' => 'Evaluation results are not available'
        ];
    }

    public function buildResultParts()
    {
        return [
            'success' => true,
            'parts' => [

            ]
        ];
    }
}