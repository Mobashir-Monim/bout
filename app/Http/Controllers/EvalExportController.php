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
        $depts = CER::where('course_evaluation_id', $request->year . "_" . $request->semester)->where('dept', "!=", "skeleton")->pluck('dept')->toArray();
        $oc = OC::where('run_id', $request->year . "_" . $request->semester)->get()->pluck('id')->toArray();
        $ocs = OCS::whereIn('offered_course_id', $oc)->get()->pluck('id')->toArray();
        
        return response()->json([
            'depts' => $depts,
            'courses' => $oc,
            'sections' => $ocs
        ]);
    }

    public function exportSection(Request $request)
    {
        $ocs = OCS::find($request->section);
        $ocs = $ocs === null ? null : $ocs->toArray();

        return response()->json([
            'success' => $ocs !== null,
            'section' => $ocs
        ]);
    }

    public function exportCourse(Request $request)
    {
        $oc = OC::find($request->course);
        $oc = $oc === null ? null : array_merge(['department' => $oc->course->provider, 'code' => $oc->course->code], $oc->toArray());

        return response()->json([
            'success' => $oc !== null,
            'course' => $oc,
        ]);
    }

    public function exportDepartment(Request $request)
    {
        $cer = CER::where('course_evaluation_id', $request->cer_id)->where('dept', $request->dept)->first();
        $cer = $cer === null ? null : $cer->toArray();

        return response()->json([
            'success' => $cer !== null,
            'department' => $cer
        ]);
    }

    public function exportMetadata(Request $request)
    {
        $factors = json_decode(CE::find($request->run)->factors);
        $m_parts = CEM::where('course_evaluation_id', $request->run)->orderBy("part", "ASC")->get();
        $matrix = "";

        foreach ($m_parts as $part) {
            $matrix .= $part->value;
        }

        $matrix = json_decode($matrix);

        return response()->json([
            'success' => true,
            'factors' => $factors,
            'matrix' => $matrix
        ]);
    }
}
