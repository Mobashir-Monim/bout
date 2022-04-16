<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\EnrollmentHelpers\Enroller;

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
            $request->stream
        );

        return response()->json([
            'success' => true
        ]);
    }
}
