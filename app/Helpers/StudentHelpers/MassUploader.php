<?php

namespace App\Helpers\StudentHelpers;

use App\Helpers\Helper;
use App\Models\Student;
use App\Models\StudentMap;

class MassUploader extends Helper
{
    public $students;

    public function __construct($students)
    {
        $this->students = $students;
        $this->uploadStudents();
    }

    public function uploadStudents()
    {
        foreach ($this->students as $row) {
            $student = $this->findStudent($this->extractStudentData($row), $row);
            $this->updateStudentData($row, $student);
        }
    }

    public function extractStudentData($data)
    {
        return [
            'id' => $data['student_id'],
            'name' => is_null($data['name']) ? 'N/A' : $data['name'],
            'program' => $data['program'],
            'department' => $data['department'],
            'school' => $data['school']
        ];
    }

    public function findStudent($data, $row)
    {
        $student = Student::find($data['id']);
        
        if (is_null($student)) {
            $student = StudentMap::where('email', $row['gsuite_email'])->first();

            if (is_null($student)) {
                $student = StudentMap::where('email', $row['usis_email'])->first();

                if (is_null($student)) {
                    $student = Student::create($data);
                    foreach (['gsuite_email', 'usis_email'] as $email)
                        $this->createStudentMap($row, $student, $email);
                } else {
                    $student = $student->student;
                }
            } else {
                $student = $student->student;
            }
        }

        return $student;
    }



    public function updateStudentData($row, $student)
    {
        if (!is_null($row['updated_student_id'])) $student->id = $row['updated_student_id'];
        if (!is_null($row['name'])) $student->name = $row['name'];
        if (!is_null($row['program'])) $student->program = $row['program'];
        if (!is_null($row['department'])) $student->department = $row['department'];
        if (!is_null($row['school'])) $student->school = $row['school'];
        $student->save();
    }

    public function createStudentMap($row, $student, $email)
    {
        if (!is_null($row[$email])) StudentMap::create([
            'student_id' => $student->id,
            'email' => $row[$email]
        ]);
    }
}