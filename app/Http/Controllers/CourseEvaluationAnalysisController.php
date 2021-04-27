<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\CourseEvaluationAnalysisHelpers\Helper;

class CourseEvaluationAnalysisController extends Controller
{
    public function index()
    {
        return view('eval-analysis.index');
    }

    public function getAnalysisReport(Request $request)
    {
        $helper = new Helper(
            $request->dist_type,
            $request->semester,
            $request->year,
            $request->chart_type,
            $request->dept,
            $request->course,
            $request->section
        );

        $helper->hasPermission();

        return view('eval-analysis.index', [
            'helper' => $helper
        ]);
    }

    public function getAnalysisData(Request $request)
    {
        $helper = new Helper(
            $request->dist_type,
            $request->semester,
            $request->year,
            $request->chart_type,
            $request->dept,
            $request->course,
            $request->section
        );

        return response()->json([
            'success' => true,
            'chart_config' => $helper->hasPermission() ? $helper->getChartConfig(false) : null
        ]);
    }
}
