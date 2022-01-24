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
        $emails = array_filter([str_replace(" ", "", $student['email']), str_replace(" ", "", $student['gsuite'])]);

        $this->sendEmail($emails, $subject, $student);
    }

    public function sendEmail($email, $subject, $student)
    {
        try {
            Mail::to($email)->bcc('academic.standards@bracu.ac.bd')->send(new EvalMail($subject, $student));
        } catch (\Throwable $th) {
            $this->fails[$email] = $th->getMessage();
        }
    }

    public function getFailureMessages()
    {
        return $this->fails;
    }
}

// apt-get -y install unzip zip nginx php8.1 php8.1-mysql php8.1-fpm php8.1-zip php8.1-xml php8.1-mbstring php8.1-gd