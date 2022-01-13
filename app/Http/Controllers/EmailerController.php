<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\EmailerHelpers\EvalMailerHelpers\StudentUpdator;
use App\Helpers\EmailerHelpers\EvalMailerHelpers\StudentFinder;
use App\Helpers\EmailerHelpers\EvalMailerHelpers\StudentMailer;
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

    public function prev(Request $request)
    {
        $student = $request->student;
        $fails = [
            $student['id'] => [
                'emails' => [],
                'errors' => []
            ]
        ];

        if (is_null($student['gsuite'])) {
            $map = StudentMap::where('email', $student['email'])->first();

            if (!is_null($map)) {
                $student['gsuite'] = StudentMap::where('student_id', $map->student_id)->where('email', 'like', '%@g.bracu.ac.bd')->first();

                if (!is_null($student['gsuite']))
                    $student['gsuite'] = $student['gsuite']->email;
            }
        }

        try {
            $email = str_replace(" ", "", $student['email']);
            Mail::to($email)->bcc('academic.standards@bracu.ac.bd')->send(new EvalMail($request->subject, $student));
        } catch (\Throwable $th) {
            $fails[$student['id']]['emails'][] = $email;
            $fails[$student['id']]['errors'][] = $th;
        }
        
        if (!is_null($student['gsuite'])) {
            try {
                $email = str_replace(" ", "", $student['gsuite']);
                Mail::to($email)->bcc('academic.standards@bracu.ac.bd')->send(new EvalMail($request->subject, $student));
            } catch (\Throwable $th) {
                $fails[$student['id']]['emails'][] = $email;
                $fails[$student['id']]['errors'][] = $th;
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Emailed student',
            'fails' => $fails,
        ]);
    }

    public function sendEvalMail(Request $request)
    {
        $student = $request->student;
        $student_helper = new StudentFinder($student['id'], $student['email']);
        $student['gsuite'] = $student_helper->getGsuiteAddresses();
        $student['gsuite'] = sizeof($student['gsuite']) > 0 ? $student['gsuite'][0] : null;

        $emailer = new StudentMailer($student, $request->subject);
        
        return response()->json([
            'success' => true,
            'message' => 'Emailed student',
            'fails' => $emailer->getFailureMessages(),
        ]);
    }
}
