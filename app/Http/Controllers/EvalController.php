<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CourseEvalSemesterConfirm as CESC;
use App\Helpers\CourseEvaluationHelpers\FactorsHelper;
use App\Helpers\CourseEvaluationHelpers\MatrixHelper;
use App\Helpers\CourseEvaluationHelpers\EvaluationHelper;
use App\Helpers\CourseEvaluationHelpers\ReportHelper;
use App\Helpers\CourseEvaluationHelpers\GeneratorHelper;
use App\Helpers\CourseEvaluationHelpers\EvaluationCopyHelper;
use App\Helpers\CourseEvaluationHelpers\FormulaHelper;
use App\Helpers\CourseEvaluationHelpers\FacultyFilter;
use App\Imports\CourseEvaluationFactorsImport as CEFI;
use App\Models\CourseEvaluation as CE;
use Excel;
use App\Helpers\CourseEvaluationAnalysisHelpers\PermissionsBuilder;
use App\Imports\SeedImport;

class EvalController extends Controller
{
    public function index(Request $request)
    {
        return view('course-eval.index', [
            'has_analytics_access' => (new PermissionsBuilder(null, false))->hasPermission()
        ]);
    }

    public function evaluate($year, $semester)
    {
        $helper = new EvaluationHelper($year, $semester);

        if (is_null($helper->eval->factors)) {
            $this->flashMessage('error', 'Please set the factors first');

            return redirect(route('course-eval.factors-config', ['year' => $year, 'semester' => $semester]));
        } 
        
        if (sizeof((array) $helper->eval->compiledMatrices) == 0) {
            $this->flashMessage('error', 'Please set the matrix first');
            
            return redirect(route('course-eval.matrix-config', ['year' => $year, 'semester' => $semester]));
        }

        return view('course-eval.evaluate.index', ['helper' => $helper]);
    }

    // public function storeResults($year, $semester, Request $request)
    // {
    //     $helper = new EvaluationHelper($year, $semester);
    //     $results = Excel::toArray(new SeedImport, $request->file('results'))[0];
    //     $helper->storeResults($results);

    //     return redirect(route('eval'));
    // }

    public function storeResults($year, $semester, Request $request)
    {
        $helper = new EvaluationHelper($year, $semester);
        // $results = Excel::toArray(new SeedImport, $request->file('results'))[0];
        $helper->storeResults($request->parts, $request->starting_index);

        // $parts = [];

        // foreach ($request->parts as $key => $part) {
        //     $parts[$key] = [gettype($part), json_encode($part)];
        // }

        return response()->json([
            'success' => true,
            'message' => 'Successfully stored',
            // 'parts' => $parts,
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
        $helper = new GeneratorHelper($request->year, $request->semester, $department);
        
        if ($helper->status['error']) {
            return view('course-eval.reports.error', ['status' => $helper->status]);
        }

        return view('course-eval.reports.dept-template', ['helper' => $helper]);
    }

    public function courseReport($year, $semester, $department, $course, Request $request)
    {
        $helper = new GeneratorHelper($request->year, $request->semester, $department, $course);
        
        if ($helper->status['error']) {
            return view('course-eval.reports.error', ['status' => $helper->status]);
        }

        if (gettype($helper->report) == 'string' || is_null($helper->report)) {
            if (is_null(json_decode($helper->report))) {
                return view('course-eval.reports.error', ['status' => ['error' => true, 'message' => 'No students evaluated this course']]);
            }
        }

        return view('course-eval.reports.course-template', ['helper' => $helper]);
    }

    public function sectionReport($year, $semester, $department, $course, $section, Request $request)
    {
        $helper = new GeneratorHelper($request->year, $request->semester, $department, $course, $section);
        
        if ($helper->status['error']) {
            return view('course-eval.reports.error', ['status' => $helper->status]);
        }

        if (gettype($helper->report) == 'string' || is_null($helper->report)) {
            if (is_null(json_decode($helper->report))) {
                return view('course-eval.reports.error', ['status' => ['error' => true, 'message' => 'No students evaluated this section']]);
            }
        }
        
        return view('course-eval.reports.section-template', ['helper' => $helper]);
    }

    public function labReport($year, $semester, $department, $course, $section, Request $request)
    {
        $helper = new GeneratorHelper($request->year, $request->semester, $department, $course, $section, true);
        
        if ($helper->status['error']) {
            return view('course-eval.reports.error', ['status' => $helper->status]);
        }

        if (gettype($helper->report) == 'string' || is_null($helper->report)) {
            if (is_null(json_decode($helper->report))) {
                return view('course-eval.reports.error', ['status' => ['error' => true, 'message' => 'No students evaluated this course']]);
            }
        }

        return view('course-eval.reports.lab-template', ['helper' => $helper]);
    }

    public function semesterConfirm(CESC $request)
    {
        $helper = new ReportHelper($request->year, $request->semester);

        return view('course-eval.index', [
            'helper' => $helper,
            'has_analytics_access' => (new PermissionsBuilder(null, false))->hasPermission()
        ]);
    }

    public function publishReport(Request $request)
    {
        $eval = CE::find($request->year . "_" . $request->semester);
        $eval->is_published = !$eval->is_published;
        $eval->save();
        $helper = new ReportHelper($request->year, $request->semester);
        
        return view('course-eval.index', [
            'helper' => $helper,
            'has_analytics_access' => (new PermissionsBuilder(null, false))->hasPermission()
        ]);
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

    public function upadateMinMax($year, $semester, Request $request)
    {
        $helper = new FactorsHelper($year, $semester);
        $helper->upadateMinMax($request->factors);

        return response()->json([
            'success' => true,
            'message' => 'Updated factors min and max vals'
        ]);
    }

    public function copyFromPrev($year, $semester)
    {
        $helper = new FactorsHelper($year, $semester);
        $helper->copyFromPrev(request()->prev_factor);

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

        if (is_null($helper->eval->factors)) {
            $this->flashMessage('error', 'Please set the factors first');

            return redirect(route('course-eval.factors-config', ['year' => $year, 'semester' => $semester]));
        }
        
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

    public function copyEvaluation(Request $request)
    {
        $helper = new EvaluationCopyHelper(
            $request->course,
            $request->source,
            $request->destination,
            $request->dept,
            $request->dept_copy,
            $request->course_copy,
            $request->section_copy
        );

        $this->flashMessage('success', "Copied data of $request->course% from $request->source to $request->destination");

        return redirect()->route('eval');
    }

    public function storeExpression($year, $semester, $dept, Request $request)
    {
        $helper = new FormulaHelper(CE::find($year . "_" . ucfirst($semester)));
        $helper->storeExpression($dept, $request->expression);

        return response()->json([
            'success' => !$helper->status['error'],
            'message' => $helper->status['message'],
        ]);
    }

    public function filterFaculty($year, $semester, Request $request)
    {
        $helper = new FacultyFilter($year, $semester, $request->search_phrase);

        return response()->json([
            'success' => true,
            'results' => $helper->results
        ]);
    }
}
