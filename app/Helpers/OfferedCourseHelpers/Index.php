<?php

namespace App\Helpers\OfferedCourseHelpers;

use App\Helpers\Helper;
use App\Models\Course;
use App\Models\OfferedCourse;
use App\Models\EnterprisePart;
use App\Models\Role;
use DB;

class Index extends Helper
{
    public $semester;
    public $year;
    public $courses;
    public $departments;

    public function __construct($semester, $year)
    {
        $this->semester = $semester;
        $this->year = $year;
        $this->departments = array_unique(EnterprisePart::whereIn('id', $this->getDepartmentsIDs())->where('is_academic_part', true)->get()->pluck('name')->toArray());

        if (auth()->user()->hasRole('super-admin')) {
            $this->departments = array_unique(Course::all()->pluck('provider')->toArray());
        }
    }

    public function getDepartmentsIDs()
    {
        return DB::table('role_user')
            ->where('role_id', Role::where('name', 'like', '%dco%')->first()->id)
            ->where('user_id', auth()->user()->id)
            ->get()->pluck('enterprise_part_id')->toArray();
    }

    public function getCourses()
    {
        $courses = OfferedCourse::whereIn(
            'course_id',
            Course::whereIn(
                'provider',
                $this->departments
            )->get()->pluck('id')->toArray()
        )->where('run_id', $this->year . "_" . ucfirst($this->semester))->get();

        if (auth()->user()->hasRole('super-admin')) {
            $courses = OfferedCourse::where('run_id', $this->year . "_" . ucfirst($this->semester))->get();
        }

        $this->objectifyCourses($courses);
    }

    public function objectifyCourses($courses)
    {
        $this->courses = [];

        foreach ($courses as $offered) {
            $this->addSections(
                $offered->sections,
                $offered->course->provider,
                $offered->course->code,
                $offered,
            );
        }
    }

    public function addSections($sections, $provider, $code, $offered)
    {
        $this->courses[$provider][$code]['is_lab'] = $offered->is_lab;
        $this->courses[$provider][$code]['has_lab'] = $offered->has_lab;
        $this->courses[$provider][$code]['title'] = $offered->course->title;
        $this->courses[$provider][$code]['id'] = $offered->id;
        $this->courses[$provider][$code]['coordinator'] = $offered->coordinator;
        $this->courses[$provider][$code]['initials'] = $offered->initials;
        $this->courses[$provider][$code]['email'] = $offered->email;

        foreach ($sections as $section) {
            $this->courses[$provider][$code]['sections'][$section->section][!$section->is_lab_faculty ? 'theory' : 'lab'][] = 
                ['name' => $section->name, 'initials' => $section->initials, 'email' => $section->email, 'id' => $section->id];
        }

        ksort($this->courses[$provider]);

        if (array_key_exists('sections', $this->courses[$provider][$code])) {
            if (!is_null($this->courses[$provider][$code]['sections'])) {
                ksort($this->courses[$provider][$code]['sections']);
            }
        }
    }
}