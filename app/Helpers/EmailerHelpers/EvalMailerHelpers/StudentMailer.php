<?php

namespace App\Helpers\EmailerHelpers\EvalMailerHelpers;

use App\Helpers\Helper;
use Illuminate\Support\Facades\Mail;
use App\Mail\EvalMail;

class StudentMailer extends Helper
{
    protected $student;
    protected $fails = [];

    public function __construct($student, $subject)
    {
        $this->student = $student;

        $this->sendEmail(str_replace(" ", "", $student['email']), $subject, $student);

        if (!is_null($student['gsuite']))
            $this->sendEmail(str_replace(" ", "", $student['gsuite']), $subject, $student);
    }

    public function sendEmail($email, $subject, $student)
    {
        try {
            Mail::to($email)->send(new EvalMail($subject, $student));
        } catch (\Throwable $th) {
            $this->fails[$email] = $th->getMessage();
        }
    }

    public function getFailureMessages()
    {
        return $this->fails;
    }
}