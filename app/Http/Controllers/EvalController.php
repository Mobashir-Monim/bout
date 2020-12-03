<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CourseEvalSemesterConfirm as CESC;
use App\Helpers\CourseEvaluationHelpers\FactorsHelper;
use App\Helpers\CourseEvaluationHelpers\MatrixHelper;
use App\Helpers\CourseEvaluationHelpers\EvaluationHelper;
use App\Helpers\CourseEvaluationHelpers\ReportHelper;
use App\Imports\CourseEvaluationFactorsImport as CEFI;
use Excel;

class EvalController extends Controller
{
    public function index(Request $request)
    {
        return view('course-eval.index');
    }

    public function evaluate($year, $semester)
    {
        $helper = new EvaluationHelper($year, $semester);

        return view('course-eval.evaluate.index', ['helper' => $helper]);
    }

    public function storeResults($year, $semester, Request $request)
    {
        $helper = new EvaluationHelper($year, $semester);
        $helper->storeResults($request->parts, $request->starting_index);

        return response()->json([
            'success' => true,
            'message' => 'Completed storing parts'
        ]);
    }

    public function report($type, $year, $semester, Request $report)
    {
        if ($type != 'dept' && $type != 'course' && $type != 'section') {
            $this->flashMessage('error', 'The report that you are trying to access does not exist 👽👽👽');
            return back();
        }

        return view("course-eval.reports.$report-template");
    }

    public function departmentReport($year, $semester, $department, Request $request)
    {
        $helper = new ReportHelper($request->year, $request->semester);
        $status = $helper->validateReportRequest($department);

        if ($status['error']) {
            return view('course-eval.reports.error', ['status' => $status]);
        }

        return view('course-eval.reports.dept-template', ['helper' => $helper]);
    }

    public function semesterConfirm(CESC $request)
    {
        $helper = new ReportHelper($request->year, $request->semester);

        return view('course-eval.index', ['helper' => $helper]);
    }

    public function publishReport(Request $request)
    {
        $helper = new ReportHelper($request->year, $request->semester);
        $helper->togglePublishStatus();
        
        return view('course-eval.index', ['helper' => $helper]);
    }

    public function factorsConfig($year, $semester)
    {
        $helper = new FactorsHelper($year, $semester);

        return view('course-eval.factors.index', ['helper' => $helper]);
    }

    public function factorsConfigSave($year, $semester, Request $request)
    {
        $helper = new FactorsHelper($year, $semester);
        $helper->addFactors($request->name, $request->short_hand, $request->description);

        return redirect(route('course-eval.matrix-config', ['year' => $year, 'semester' => $semester]));
    }

    public function copyFromPrev($year, $semester)
    {
        $helper = new FactorsHelper($year, $semester);
        $helper->copyFromPrev(request()->year, request()->semester);

        return redirect(route('course-eval.matrix-config', ['year' => $year, 'semester' => $semester]));
    }

    public function bulkUpload($year, $semester, Request $request)
    {
        $helper = new FactorsHelper($year, $semester);
        $rows = Excel::toCollection(new CEFI, $request->file('factors_file'))[0];
        $helper->addFactors($rows->pluck('name'), $rows->pluck('short_hand'), $rows->pluck('description'));

        return redirect(route('course-eval.factors-config', ['year' => $year, 'semester' => $semester]));
    }

    public function matrixConfig($year, $semester)
    {
        $helper = new MatrixHelper($year, $semester);
        
        return view('course-eval.matrix.index', ['helper' => $helper]);
    }

    public function matrixConfigSave($year, $semester, Request $request)
    {
        $helper = new MatrixHelper($year, $semester);
        $helper->storeMatrix($request->parts, $request->starting_index);

        return response()->json([
            'success' => true,
            'message' => 'Ready for next package'
        ]);
    }
}
