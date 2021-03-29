<?php

namespace App\Helpers\StudentHelpers;

use App\Helpers\Helper;
use App\Models\Student;
use App\Models\StudentMap;

class DataRetriever extends Helper
{
    protected $index;
    protected $students;
    protected $template;
    protected $results = [];

    public function __construct($data, $index = 0, $cluster = 100)
    {
        $index = is_null($index) ? 0 : $index;
        $cluster = is_null($cluster) ? 100 : $cluster;
        $this->buildTemplate($data);
        $this->findStudents($index, $cluster);
        $this->buildResults();
    }

    public function buildTemplate($data)
    {
        $accepted = ['id', 'name', 'email', 'gsuite_email', 'usis_email'];
        $this->template = [];

        foreach ($data as $key) {
            if (in_array($key, $accepted)) {
                $this->template[$key] = '';
            }
        }
    }

    public function findStudents($index, $cluster)
    {
        $this->students = Student::where('id', '>', $index)->take($cluster)->get();
    }

    public function buildResults()
    {
        foreach ($this->students as $student) {
            $temp = [];

            foreach ($this->template as $key => $value) {
                if (endswith($key, 'email')) {
                    $this->compileEmail($key, $student, $temp);
                } else {
                    $temp[$key] = $student->$key;
                }
            }

            $this->results[] = $temp;
        }

    }

    public function compileEmail($key, $student, &$temp)
    {
        $flag = $key == 'email';

        if ($key == 'gsuite_email' || $flag) {
            $map = StudentMap::where('student_id', $student->id)->where('email', 'like', '%@g.bracu.ac.bd')->first();
            $temp['gsuite_email'] = is_null($map) ? null : $map->email;
        }

        if ($key == 'usis_email' || $flag) {
            $map = StudentMap::where('student_id', $student->id)->where('email', 'not like', '%@g.bracu.ac.bd')->first();
            $temp['usis_email'] = is_null($map) ? null : $map->email;
        }
    }

    public function getResults()
    {
        return $this->results;
    }
}