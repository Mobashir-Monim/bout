<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\EmailerHelpers\EvalMailerHelpers\StudentUpdator;
use Illuminate\Support\Facades\Mail;
use App\Mail\EvalMail;
use App\Models\Student;
use App\Models\StudentMap;

class EmailerController extends Controller
{
    public function index()
    {
        return view('emailer.index');
    }

    public function evalMailer()
    {
        return view('emailer.eval.index');
    }

    public function sendEvalMail(Request $request)
    {
        $student = $request->student;

        if (is_null($student['gsuite'])) {
            $map = StudentMap::where('email', $student['email'])->first();

            if (!is_null($map)) {
                $student['gsuite'] = StudentMap::where('student_id', $map->student_id)->where('email', 'like', '%@g.bracu.ac.bd')->first();

                if (!is_null($student['gsuite']))
                    $student['gsuite'] = $student['gsuite']->email;
            }
        }

        try {
            $email = str_replace(" ", "", $request->student['email']);
            Mail::to($email)->send(new EvalMail($request->subject, $student));

            if (!is_null($request->student['gsuite'])) {
                $email = str_replace(" ", "", $request->student['gsuite']);
                Mail::to($email)->send(new EvalMail($request->subject, $student));
            }
        } catch (\Throwable $th) {}


        return response()->json([
            'success' => true,
            'message' => 'Emailed student',
        ]);
    }
}
