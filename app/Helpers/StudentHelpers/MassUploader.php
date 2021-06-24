<?php

namespace App\Helpers\StudentHelpers;

use App\Helpers\Helper;
use App\Models\Student;
use App\Models\StudentMap;

class MassUploader extends Helper
{
    public $students;
    public $errors = [];

    public function __construct($students)
    {
        $this->students = $students;
        $this->uploadStudents();
    }

    public function uploadStudents()
    {
        foreach ($this->students as $row) {
            try {
                $student = $this->findStudent($this->extractStudentData($row), $row);
                $this->updateStudentData($row, $student);
            } catch (\Throwable $error) {
                $this->errors[] = $error->getMessage();
            }
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
                } else {
                    $student = $student->student;
                }
            } else {
                $student = $student->student;
            }
        }

        foreach (['gsuite_email', 'usis_email'] as $email)
            $this->createStudentMap($row, $student, $email);

        return $student;
    }



    public function updateStudentData($row, $student)
    {
        $updatable = [];

        foreach (['updated_student_id', 'name', 'program', 'department', 'school'] as $item) {
            if (!is_null($row[$item])) {
                $updatable[$item] = $row[$item];
            }
        }

        $student->update($updatable);
    }

    public function createStudentMap($row, $student, $email)
    {
        if (is_null(StudentMap::where('email', $row[$email])->first())) {
            if (!is_null($row[$email])) {
                StudentMap::create([
                    'student_id' => $student->id,
                    'email' => $row[$email]
                ]);
            }
        }
    }
}