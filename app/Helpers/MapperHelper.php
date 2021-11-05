<?php

namespace App\Helpers;

use App\Models\StudentMap;
use App\Models\Student;

class MapperHelper extends Helper
{
    protected $mapType;

    public function __construct($mapType)
    {
        $this->mapType = $mapType;
    }

    public function mapStudents($data)
    {
        if ($this->mapType == 'username_to_id') {
            return $this->usernameToStudentID($data);
        } elseif ($this->mapType == 'id_to_username') {
            return $this->studentIDToUsername($data);
        } elseif ($this->mapType == 'id_to_email') {
            return $this->studentIDToUSISEmail($data);
        } elseif ($this->mapType == 'id_to_gsuite') {
            return $this->studentIDToGsuiteEmail($data);
        } else {
            return $this->gsuiteEmailToStudentID($data);
        }
    }

    public function usernameToStudentID($data)
    {
        foreach ($data as $k => $row) {
            foreach ($row as $key => $value) {
                $data[$k]['id'] = StudentMap::where($key, $value)->first();
                $data[$k]['id'] = is_null($data[$k]['id']) ? 'Not found, please let the devs know' : $data[$k]['id']->student->student_id;
            }
        }

        return $data;
    }

    public function studentIDToUsername($data)
    {
        foreach ($data as $k => $row) {
            foreach ($row as $key => $value) {
                $usernames = StudentMap::whereIn('student_id', Student::where($key, $value)->get()->pluck('id')->toArray())->get();
                $data[$k]['username'] = sizeof($usernames) == 0 ? 'Not found, please let the devs know' : $this->stripAndGlue($usernames->pluck('username')->toArray());
            }
        }

        return $data;
    }

    public function studentIDToUSISEmail($data)
    {
        foreach ($data as $k => $row) {
            foreach ($row as $key => $value) {
                $usernames = StudentMap::whereIn('student_id', Student::where($key, $value)->get()->pluck('id')->toArray())->where('email', 'not like', '%@g.bracu.ac.bd')->get();
                $data[$k]['usis_email'] = sizeof($usernames) == 0 ? 'Not found, please let the devs know' : $this->stripAndGlue($usernames->pluck('email')->toArray());
            }
        }

        return $data;
    }

    public function studentIDToGsuiteEmail($data)
    {
        foreach ($data as $k => $row) {
            foreach ($row as $key => $value) {
                $usernames = StudentMap::whereIn('student_id', Student::where($key, $value)->get()->pluck('id')->toArray())->where('email', 'like', '%@g.bracu.ac.bd')->get();
                $data[$k]['gsuite_email'] = sizeof($usernames) == 0 ? 'Not found, please let the devs know' : $this->stripAndGlue($usernames->pluck('email')->toArray());
            }
        }

        return $data;
    }

    public function gsuiteEmailToStudentID($data)
    {
        foreach ($data as $k => $row) {
            foreach ($row as $key => $value) {
                $usernames = StudentMap::where($key, $value)->get();
                $data[$k]['student_id'] = sizeof($usernames) == 0 ? 'Not found, please let the devs know' : $this->stripAndGlue(Student::whereIn('id', $usernames->pluck('student_id')->toArray())->get()->pluck('student_id')->toArray());
            }
        }

        return $data;
    }

    public function stripAndGlue($values)
    {
        $values = array_filter($values, fn($value) => !is_null($value) && $value !== '');
        $values = implode(',', $values);

        return $values;
    }
}