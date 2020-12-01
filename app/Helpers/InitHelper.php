<?php

namespace App\Helpers;

use App\Models\Student;
use App\Models\StudentMap;

class InitHelper extends Helper
{
    public function seedPart($part)
    {
        foreach ($part as $key => $row) {
            $student = $this->findStudent($row);

            if (is_null($student)) {
                $this->studentCreate($row);
            } else {
                $this->studentUpdate($row, $student);
            }
        }
    }

    public function findStudent($row)
    {
        $student = Student::find($row['id']);

        if (is_null($student)) {
            $student = StudentMap::where('email', $row['gsuite'])->first();
            $student = !is_null($student) ? $student->student : null;
        }

        if (is_null($student)) {
            $student = StudentMap::where('email', $row['non-gsuite'])->first();
            $student = !is_null($student) ? $student->student : null;
        }

        return $student;
    }

    public function studentCreate($row)
    {
        $student = Student::create(['id' => $row['id'], 'name' => $row['name']]);

        if (!is_null($row['gsuite_username'])) {
            if (is_null(StudentMap::where('email', $row['gsuite'])->first())) {
                $map = StudentMap::create(['student_id' => $student->id, 'email' => $row['gsuite'], 'username' => $row['gsuite_username']]);
            }
        }

        if (!is_null($row['nongsuite_username'])) {
            if (is_null(StudentMap::where('email', $row['non_gsuite'])->first())) {
                $map = StudentMap::create(['student_id' => $student->id, 'email' => $row['non_gsuite'], 'username' => $row['nongsuite_username']]);
            }
        }
    }

    public function studentUpdate($row, $student)
    {
        $student->name = $row['name'];
        $student->id = $row['id'];
        $student->save();
    }
}