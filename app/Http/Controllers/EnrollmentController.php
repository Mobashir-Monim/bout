<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\EnrollmentHelpers\Enroller;
use App\Models\OfferedCourseSection as OCS;

class EnrollmentController extends Controller
{
    public function index()
    {
        return view('student.enrollments.index');
    }

    public function enroll(Request $request)
    {
        $enroller = new Enroller(
            $request->department,
            $request->course,
            $request->section,
            $request->students,
            $request->semester,
            $request->year,
        );
        $enroller->enrollStudents();

        return response()->json([
            'success' => true
        ]);
    }
}
// 219bc2ed-7342-40af-8b41-9b611d5f1871