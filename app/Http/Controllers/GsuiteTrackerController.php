<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Helpers\StudentHelpers\InformationUpdater;

class GsuiteTrackerController extends Controller
{
    public function index()
    {
        $students = Student::paginate(50);

        return view('gsuite-tracker.index', ['students' => $students]);
    }

    public function update(Student $student, Request $request)
    {
        // dd($request->all());
        $helper = new InformationUpdater($student, $request);
        flash('Successfully updated information of student')->success();

        return redirect()->back();
    }
}
