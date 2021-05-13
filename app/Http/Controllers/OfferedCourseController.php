<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\OfferedCourseHelpers\Index as OCHI;
use App\Helpers\OfferedCourseHelpers\Creator as OCHC;
use App\Helpers\OfferedCourseHelpers\Updator as OCHU;
use App\Helpers\OfferedCourseHelpers\Deletor as OCHD;
use App\Helpers\OfferedCourseHelpers\ListHelper as OCL;
use App\Models\Course;
use App\Helpers\CourseEvaluationHelpers\EvaluationCopyHelper;
use DB;

class OfferedCourseController extends Controller
{
    public function index(Request $request)
    {
        if (!is_null($request->semester) && !is_null($request->year)) {
            $helper = new OCHI($request->semester, $request->year);
            $helper->getCourses();
            
            return view('offered-course.index', ['helper' => $helper]);
        }

        return view('offered-course.index');
    }

    public function create($year, $semester, Request $request)
    {
        $helper = new OCHC($year, $semester, $request->type);

        return response()->json([
            'success' => true,
            'message' => "Successfully created $request->type",
            'creation_id' => $helper->create($request),
        ]);
    }

    public function update($year, $semester, Request $request)
    {
        $helper = new OCHU($year, $semester, $request->type);
        $helper->update($request);

        return response()->json([
            'success' => true,
            'message' => "Successfully updated $request->type",
        ]);
    }

    public function delete($year, $semester, Request $request)
    {
        $helper = new OCHD($year, $semester, $request->type);
        $helper->delete($request);

        return response()->json([
            'success' => true,
            'message' => "Successfully deleted $request->type",
            'sent' => $request->all()
        ]);
    }

    public function updateProvider(Request $request)
    {
        $courses = Course::where(\DB::raw('BINARY `provider`'), $request->old_provider)->get();
        $count = count($courses);

        foreach ($courses as $course) {
            $course->provider = strtoupper($request->new_provider);
            $course->save();
        }

        flash("Updated \"$request->old_provider\" to \"$request->new_provider\" for $count course(s)")->success();

        return $this->index($request);
    }

    public function listCourses(Request $request)
    {
        $helper = new OCL($request->all());

        return view('offered-course.list-group', [
            'course_list' => $helper->getIndexCourses()
        ]);
    }

    public function listCourseDetails(Request $request)
    {
        $helper = new OCL(['offered_course_id' => $request->offered_course_id]);

        return response()->json([
            'success' => true,
            'details' => $helper->getOfferedCourseDetails(),
        ]);
    }

    public function updateOfferedInformation(Request $request)
    {
        $helper = new OCHU(null, null, $request->type, $request->id);
        $helper->update($request);

        return response()->json([
            'success' => true,
            'message' => 'Updated information'
        ]);
    }

    public function copyEvaluation(Request $request)
    {
        $helper = new EvaluationCopyHelper(
            null,
            $request->source,
            $request->destination,
            null,
            null,
            $request->type == 'course',
            $request->type == 'section'
        );

        return response()->json([
            'success' => true,
            'message' => 'Copied evaluation'
        ]);
    }
}
