<?php

namespace App\Helpers\StudentHelpers;

use App\Helpers\Helper;
use App\Models\Student;
use App\Models\StudentMap;

class Search extends Helper
{
    public $students;

    public function __construct($phrase)
    {
        $students = $this->matchName($phrase);
        $students = $students->merge($this->matchEmail($phrase));
        $students = $students->merge($this->matchID($phrase));

        $this->students = Student::whereIn('id', $students->pluck('id')->toArray())->paginate(30);
    }

    public function matchName($phrase)
    {
        return Student::where('name', 'like', "%$phrase%")->get();
    }

    public function matchEmail($phrase)
    {
        $maps = StudentMap::where('email', 'like', "%$phrase%")->get()->pluck('student_id')->toArray();

        return Student::whereIn('id', $maps)->get();
    }

    public function matchID($phrase)
    {
        return Student::where('id', 'like', "%$phrase%")->get();
    }

    public function getPage()
    {
        $page = is_null(request()->page) ? 1 : request()->page;
        $page = $page < 0 ? 1 : $page;

        return $page;
    }
}