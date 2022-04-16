<?php

namespace App\Helpers\EnrollmentHelpers;

use App\Helpers\Helper;
use App\Models\Course;
use App\Models\OfferedCourse as OC;
use App\Models\OfferedCourseSection as OCS;
use App\Models\Student;
use App\Models\StudentMap;

class Enroller extends Helper
{
    public $sections;
    public $students = [];

    public function __construct($department, $course, $section, $students, $semester, $year)
    {
        $this->sections = $this->findSection($department, $course, $section, $semester, $year);
        $this->findStudents($students);
    }

    public function findSection($department, $course, $section, $semester, $year)
    {
        $course = Course::select('id')->where('code', $course)->where('provider', $department);
        $oc = OC::select('id')->where('run_id', $year . "_" . $semester)->whereIn('course_id', $course);
        return OCS::where('section', $section)->whereIn('offered_course_id', $oc)->get();
    }

    public function findStudents($students)
    {
        foreach ($students as $student) {
            $searchedStudent = Student::where('student_id', $student['student_id'])->first();

            if (is_null($searchedStudent)) {
                $searchedStudent = StudentMap::where('email', $student['gsuite'])->first();
                $searchedStudent = is_null($searchedStudent) ? null : $searchedStudent->student;
            }

            if (!is_null($searchedStudent)) {
                $this->students[] = $searchedStudent->id;
            }
        }
    }

    public function enrollStudents()
    {
        $students = array_unique($this->students);
        
        foreach ($this->sections as $section) {
            $section->enrollments = $students;
            $section->save();
        }
    }
}