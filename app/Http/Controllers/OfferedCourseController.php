<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\OfferedCourseHelpers\Index as OCHI;
use App\Helpers\OfferedCourseHelpers\Creator as OCHC;
use App\Helpers\OfferedCourseHelpers\Updator as OCHU;
use App\Helpers\OfferedCourseHelpers\Deletor as OCHD;

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
}