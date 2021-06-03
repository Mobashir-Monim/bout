<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\EmailerHelpers\EvalMailerHelpers\StudentUpdator;
use Illuminate\Support\Facades\Mail;
use App\Mail\EvalMail;
use App\Models\Student;

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
        new StudentUpdator($request->student);
        $student = Student::find($request->student['id']);
        $fails = [];

        foreach ($student->maps as $connection) {
            try {
                $email = str_replace(" ", "", $connection->email);
                Mail::to($email)->send(new EvalMail($request->subject, $request->student));
            } catch (\Throwable $th) {
                $fails[] = $th;
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Emailed student',
            'fails' => $fails
        ]);
    }
}
