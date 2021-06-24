<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Helpers\StudentHelpers\InformationUpdater;
use App\Helpers\StudentHelpers\MassUploader;
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
        
        if (sizeof($helper->errors) == 0) {
            flash('Successfully updated information of student')->success();
        } else {
            flash("The following errors occured during update: ". implode(',', $helper->errors))->error();
        }

        return redirect()->back();
    }

    public function search(Request $request)
    {
        if ($request->phrase == "") {
            return redirect()->route('it-team.student.emails.index');
        }

        return redirect()->route('it-team.student.search.results', ['phrase' => $request->phrase]);
    }

    public function searchResult($phrase, Request $request)
    {
        return view('gsuite-tracker.index', [
            'students' => (new Search($phrase))->students,
            'phrase' => $phrase
        ]);
    }

    public function upload(Request $request)
    {
        $helper = new MassUploader($request->students);

        return response()->json([
            'success' => true,
            'message' => 'Successfully added students',
            'errors' => $helper->errors
        ]);
    }

    public function export(Request $request)
    {
        $students = [];
        $last = 0;

        foreach (Student::where('id', '>', $request->last_id)->take(250)->get() as $student) {
            $students[] = [
                'student_id' => $student->id,
                'name' => $student->name,
                'usis_email' => $student->usisEmails,
                'gsuite_email' => $student->gsuiteEmails,
                'program' => $student->program,
                'department' => $student->department,
                'school' => $student->school
            ];
            $last = $student->id;
        }

        return response()->json([
            'success' => true,
            'students' => $students,
            'has_more' => count(Student::where('id', '>', $last)->get()) > 0
        ]);
    }
}
