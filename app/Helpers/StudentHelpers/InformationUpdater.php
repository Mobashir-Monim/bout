<?php

namespace App\Helpers\StudentHelpers;

use App\Helpers\Helper;
use App\Models\Student;
use App\Models\StudentMap;

class InformationUpdater extends Helper
{
    public $errors = [];

    public function __construct($student, $request, $update_id_only = false)
    {
        $this->student = $student;
        try {
            $this->updateStudentID($student, $request->student_id);
        
            if (!$update_id_only) {
                $this->updateStudentInfo($student, $request);
                $this->updateMaps($request);
            }
        } catch (\Throwable $error) {
            $this->errors[] = $error->getMessage();
        }
    }

    public function updateStudentID(&$student, $id)
    {
        if ($student->student_id != $id) {
            $student->student_id = $id;
            $student->save();
        }
    }

    public function updateStudentInfo(&$student, $request)
    {
        $student->student_id = $request->student_id;
        $student->name = $request->name;
        $student->program = $request->program;
        $student->department = $request->department;
        $student->school = $request->school;
        $student->save();
    }

    public function extractEmails($request, $id)
    {
        $extracted = [];
        $emails = explode(",", str_replace(" ", "", "$request->usis_emails, $request->gsuite"));
        $emails = array_filter($emails, fn($value) => !is_null($value) && $value !== '');
        
        foreach ($emails as $email) {
            $email = str_replace(" ", "", $email);
            $extracted[$email] = StudentMap::where('student_id', $id)->where('email', $email)->first();
        }

        return $extracted;
    }

    public function includeDeletables($diff, $id)
    {
        $excludables = [];

        foreach ($diff as $email => $change) {
            if (!is_null($change) || $email == "" || $email == " ") {
                $excludables[] = $change->id;
            }
        }

        $diff['delete'] = StudentMap::where('student_id', $id)->whereNotIn('id', $excludables)->get();
        
        return $diff;
    }

    public function buildMapDiff($request)
    {
        $diff = $this->extractEmails($request, $this->student->id);
        $diff = $this->includeDeletables($diff, $request->student->id);
        
        return $diff;
    }

    public function updateMaps($request)
    {
        foreach ($this->buildMapDiff($request) as $key => $content) {
            if (is_null($content)) {
                $existing = StudentMap::where('email', $key)->first();
                $create_data = ['student_id' => $this->student->id, 'email' => $key, 'username' => null];

                if (!is_null($existing)) {
                    $create_data['username'] = $existing->username;
                    $existing->delete();
                }

                StudentMap::create($create_data);
            } elseif ($key == 'delete') {
                foreach ($content as $deletable) {
                    $deletable->delete();
                }
            } else {
                $content->email = $key;
                $content->save();
            }
        }
    }
}