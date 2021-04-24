<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CourseEvaluationAnalysisController extends Controller
{
    public function index()
    {
        return view('eval-analysis.index');
    }
}
