<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Helpers\StudentHelpers\InformationUpdater;
use App\Helpers\StudentHelpers\Search;

class GsuiteTrackerController extends Controller
{
    public function index()
    {
        $students = Student::paginate(30);

        return view('gsuite-tracker.index', ['students' => $students]);
    }

    public function update(Student $student, Request $request)
    {
        $helper = new InformationUpdater($student, $request);
        flash('Successfully updated information of student')->success();

        return redirect()->back();
    }

    public function search(Request $request)
    {
        if ($request->phrase == "") {
            return redirect()->route('it-team.student.emails.index');
        }

        return view('gsuite-tracker.index', [
            'students' => (new Search($request->phrase))->students,
            'phrase' => $request->phrase
        ]);
    }
}
