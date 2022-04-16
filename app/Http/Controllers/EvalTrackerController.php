<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\EvalTracker;
use App\Helpers\CourseEvaluationTracker\TrackerHelper;
use App\Helpers\CourseEvaluationTracker\SheetConnector;

class EvalTrackerController extends Controller
{
    public function index()
    {
        return view('course-eval.tracker.index', [
            'trackers' => EvalTracker::all()
        ]);
    }

    public function semesterConfrim(Request $request)
    {
        $helper = new TrackerHelper(ucfirst($request->semester), $request->year);
        
        return view('course-eval.tracker.index', [
            'helper' => $helper,
            'trackers' => EvalTracker::all()
        ]);

    }

    public function studentList(Request $request)
    {
        $helper = new TrackerHelper(ucfirst($request->semester), $request->year);

        return response()->json([
            'success' => true,
            'students' => $helper->getStudentList($request->section),
            'section' => $helper->getSectionDetails($request->section)
        ]);
    }

    public function responses(Request $request)
    {
        $helper = new SheetConnector($request->year . "_" . $request->semester, $request->section);

        return response()->json([
            'success' => true,
            'collated' => $helper->collated
        ]);
    }

    public function create()
    {
        $providers = array_values(array_unique(Course::select('provider')->get()->pluck('provider')->toArray()));
        
        return view('course-eval.tracker.create', [
            'providers' => $providers
        ]);
    }

    public function store(Request $request)
    {
        EvalTracker::create([
            'course_evaluation_id' => $request->year . '_' . $request->semester,
            'meta' => json_decode($request->trackers, true)
        ]);

        return redirect()->route('eval-tracker.index');
    }
}
