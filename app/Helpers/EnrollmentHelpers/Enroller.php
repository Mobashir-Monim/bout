<?php

namespace App\Helpers\EnrollmentHelpers;

use App\Helpers\Helper;
use App\Helpers\StudentHelpers\Search;
use App\Helpers\StudentHelpers\MassUploader;
use App\Models\Course;
use App\Models\OfferedCourse as OC;
use App\Models\OfferedCourseSection as OCS;
use App\Models\StudentEnrollment as SE;

class Enroller extends Helper
{
    public $section;
    public $students = [];
    public $newAdditions = [];

    public function __construct($department, $course, $section, $students, $semester, $year)
    {
        $this->section = $this->findSection($department, $course, $section, $semester, $year);
        $this->findStudents($students);
        $this->enrollStudents($semester, $year);
    }

    public function findSection($department, $course, $section, $semester, $year)
    {
        $course = Course::select('id')->where('code', $course)->where('provider', $department);
        $oc = OC::select('id')->where('run_id', $year . "_" . $semester)->whereIn('course_id', $course);
        return OCS::where('section', $section)->whereIn('offered_course_id', $oc)->first();
    }

    public function findStudents($students)
    {
        foreach ($students as $student) {
            $searchedStudent = $this->searchStudent($this->extractStudentInfo($student));

            if (!is_null($searchedStudent)) {
                $this->students[] = $searchedStudent->id;
            }
        }

        if (sizeof($this->newAdditions) != 0) {
            new MassUploader($this->newAdditions);

            foreach ($this->newAdditions as $student)
                $this->students[] = $this->searchStudent($student)->id;
        }
    }

    public function extractStudentInfo($student)
    {
        return [
            "student_id" => $student['student_id'],
            "name" => $this->valueCheck($student['name'], "N/A"),
            "usis_email" => null,
            "gsuite_email" => $this->valueCheck($student['gsuite'], null),
            "program" => "N/A",
            "phone" => null,
            "department" => "N/A",
            "school" => "N/A"
        ];
    }

    public function valueCheck($value, $defVal)
    {
        if ($value === null || $value === "") {
            return $defVal;
        }

        return $value;
    }

    public function searchStudent($student)
    {
        $returnee = (new Search($student['student_id']))->students[0];

        if (is_null($returnee)) {
            $returnee = (new Search($student['gsuite_email']))->students[0];

            if (is_null($returnee)) {
                $this->newAdditions[] = $student;
                
                return null;
            } else {
                $returnee->student_id = $student['student_id'];
                $returnee->save();
            }
        }

        return $returnee;
    }

    public function enrollStudents($semester, $year)
    {
        $run = $year . "_" . $semester;
        foreach ($this->students as $student) {
            if (is_null(SE::where('run_id', $run)
                ->where('student_id', $student)
                ->where('offered_course_section_id', $this->section->id)
            ->first())) {
                SE::create([
                    'run_id' => $run,
                    'student_id' => $student,
                    'offered_course_section_id' => $this->section->id
                ]);
            }
        }
    }
}