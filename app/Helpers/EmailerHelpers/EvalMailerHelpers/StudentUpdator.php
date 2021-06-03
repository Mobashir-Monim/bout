<?php

namespace App\Helpers\EmailerHelpers\EvalMailerHelpers;

use App\Helpers\Helper;
use App\Helpers\StudentHelpers\InformationUpdater;
use App\Models\Student;
use App\Models\StudentMap;

class StudentUpdator extends Helper
{
    public $student;
    public $map;

    public function __construct($student)
    {
        if (!$this->findStudent($student['id'], $student['email'])) {
            $this->addStudent($student);
        }

        $this->updateMaps($student['email']);
    }

    public function findStudent($id, $email)
    {
        $this->student = Student::find($id);
        $this->map = StudentMap::where('email', $email)->first();

        if (is_null($this->student) && is_null($this->map))
            return false;

        if (is_null($this->student) && !is_null($this->map)) {
            $this->student = Student::find($this->map->student_id);
            
            if (!is_null($this->student))
                $updator = new InformationUpdater($this->student, json_decode(json_encode(['student_id' => $id])), true);
        }

        return true;
    }

    public function addStudent($student)
    {
        $this->student = Student::create([
            'id' => $student['id'],
            'name' => $student['name']
        ]);
    }

    public function updateMaps($email)
    {
        $flag = false;

        foreach ($this->student->maps as $connection) {
            if ($connection->email == $email)
                $flag = true;
        }

        if (!$flag) {
            if (is_null($this->map)) {
                StudentMap::create(['student_id' => $this->student->id, 'email' => $email]);
            } else {
                $this->map->student_id = $this->student->id;
                $this->map->save();
            }
        }
    }
}