<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\OfferedCourse as OC;
use App\Models\OfferedCourseSection as OCS;
use App\Models\CourseEvaluationMatrix as CEM;
use App\Models\CourseEvaluationResult as CER;
use App\Models\CourseEvaluation as CE;

class EvalExportController extends Controller
{
    public function index()
    {
        return view("course-eval.exports.index");
    }

    public function stats(Request $request)
    {
        $depts = array_values(array_unique(Course::whereIn("id", OC::select('course_id')->where('run_id', $request->year . "_" . $request->semester))->get()->pluck("provider")->toArray()));
        $oc = OC::where('run_id', $request->year . "_" . $request->semester)->get()->pluck('id')->toArray();
        $ocs = OCS::whereIn('offered_course_id', $oc)->get()->pluck('id')->toArray();
        
        return response()->json([
            'depts' => $depts,
            'courses' => $oc,
            'sections' => $ocs
        ]);
    }
}