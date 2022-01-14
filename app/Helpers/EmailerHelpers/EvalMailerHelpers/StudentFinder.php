<?php

namespace App\Helpers\EmailerHelpers\EvalMailerHelpers;

use App\Helpers\Helper;
use App\Models\Student;
use App\Models\StudentMap;

class StudentFinder extends Helper
{
    protected $student_id;
    protected $student_email;
    protected $student;

    public function __construct($student_id, $student_email)
    {
        $this->student_id = $student_id;
        $this->student_email = $student_email;

        if (!$this->findStudentByID())
            $this->findStudentByEmail();
    }

    public function findStudentByID()
    {
        $student = Student::where('student_id', $this->student_id)->first();
        
        if (is_null($student))
            return false;

        $this->student = $student;

        return true;
    }

    public function findStudentByEmail()
    {
        $student = StudentMap::where('email', $this->student_email);

        if (is_null($student))
            return false;

        $this->student = $student;

        return true;
    }

    public function getUsisAddresses()
    {
        return is_null($this->student) ? [] : $this->student->usisEmailsArray(false);
    }

    public function getGsuiteAddresses()
    {
        return is_null($this->student) ? [] : $this->student->gsuiteEmailsArray(false);
    }
}