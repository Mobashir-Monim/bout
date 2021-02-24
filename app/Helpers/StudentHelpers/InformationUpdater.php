<?php

namespace App\Helpers\StudentHelpers;

use App\Helpers\Helper;
use App\Models\StudentMap;

class InformationUpdater extends Helper
{
    public function __construct($student, $request)
    {
        $this->updateStudentID($student, $request->student_id);
        $this->updateStudentInfo($student, $request);
        $this->updateMaps($request);
    }

    public function updateStudentID($student, $id)
    {
        if ($student->id != $id) {
            $maps = $student->maps;

            foreach ($maps as $connection) {
                $connection->student_id = $id;
                $connection->save();
            }

            $student->id = $id;
            $student->save();
        }
    }

    public function updateStudentInfo($student, $request)
    {
        $student->name = $request->name;
        $student->program = $request->program;
        $student->department = $request->department;
        $student->school = $request->school;
        $student->save();
    }

    public function extractEmails($request, $id)
    {
        $extracted = [];
        
        foreach ([str_replace(" ", "", $request->usis_emails), str_replace(" ", "", $request->gsuite)] as $emails) {
            foreach (explode(',', $emails) as $email) {
                $email = str_replace(" ", "", $email);
                $extracted[$email] = StudentMap::where('student_id', $id)->where('email', $email)->first();
            }
        }

        return $extracted;
    }

    public function includeDeletables($diff, $id)
    {
        $excludables = [];

        foreach ($diff as $email => $change) {
            if (!is_null($change)) {
                $excludables[] = $change->id;
            }
        }

        $diff['delete'] = StudentMap::where('student_id', $id)->whereNotIn('id', $excludables)->get();
        
        return $diff;
    }

    public function buildMapDiff($request)
    {
        $diff = $this->extractEmails($request, $request->student_id);
        $diff = $this->includeDeletables($diff, $request->student_id);

        return $diff;
    }

    public function updateMaps($request)
    {
        foreach ($this->buildMapDiff($request) as $key => $content) {
            if (is_null($content)) {
                StudentMap::create(['student_id' => $request->student_id, 'email' => $key]);
            } elseif ($key == 'delete') {
                foreach ($content as $deletable) {
                    $deletable->delete();
                }
            } else {
                $content->email = $key;
            }
        }
    }
}