<?php

namespace App\Helpers\CourseEvaluationHelpers;

use App\Helpers\Helper;
use App\Models\CourseEvaluation as CE;
use App\Models\CourseEvaluationResult as CER;
use App\Models\Course;
use App\Models\OfferedCourse as OC;
use App\Models\OfferedCourseSection as OCS;

class EvaluationHelper extends Helper
{
    public $eval = null;
    public $year = null;
    public $semester = null;
    public $lab_courses = null;
    public $fractions = [];
    public $courses;

    public function __construct($year, $semester)
    {
        $this->year = $year;
        $this->semester = $semester;
        $this->eval = CE::find($year . "_" . ucfirst($semester));
        $this->getLabCourses();
        $this->getFractions();

        if (is_null($this->eval)) {
            $this->eval = CE::create(['id' => $year . "_" . ucfirst($semester)]);
        }
    }

    public function getLabCourses()
    {
        $is_lab = OC::where('run_id', $this->year . "_" . ucfirst($this->semester))->where('is_lab', true)->get()->pluck('course_id')->toArray();
        $has_lab = OC::where('run_id', $this->year . "_" . ucfirst($this->semester))->where('has_lab', true)->get()->pluck('course_id')->toArray();
        $cids = array_unique(array_merge($is_lab, $has_lab));
        $this->lab_courses = Course::whereIn('id', $cids)->get()->pluck('code')->toArray();
    }

    public function getFractions()
    {
        $offereds = OC::where('run_id', $this->year . "_" . ucfirst($this->semester))->get();
        $courses = Course::whereIn('id', $offereds->pluck('course_id')->toArray())->get();
        $this->courses = $courses->pluck('code')->toArray();

        foreach ($courses as $course) {
            if (!array_key_exists($course->code, $this->fractions)) {
                $this->fractions[$course->code] = [];

                if (count($courses->where('code', $course->code)) > 1) {
                    foreach ($courses->where('code', $course->code) as $c) {
                        $sections = [];

                        foreach ($offereds->where('course_id', $c->id)->first()->sections as $section)
                            if (!in_array($section->section, $sections)) $sections[] = $section->section;

                        $this->fractions[$course->code][] = ['frac' => $c->provider, 'sections' => implode(',', $sections)];
                    }
                } else {
                    $this->fractions[$course->code][] = ['frac' => $course->provider, 'sections' => ''];
                }
            }
        }
    }

    public function storeResults($parts, $index)
    {
        if ($index == 0) {
            $this->pruneResults();
            $this->unpublishResults();
        }

        foreach ($parts as $key => $part) {
            if (!is_null($part)) {
                if ($part['type'] == 'skeleton') {
                    $this->storeInResults(base64_decode($part['data']));
                } else {
                    $this->storePart($part);
                }
            }
        }
    }

    public function pruneResults()
    {
        foreach ($this->eval->results as $part) {
            $part->delete();
        }
    }

    public function unpublishResults()
    {
        if ($this->eval->is_published) {
            $this->eval->is_published = false;
            $this->eval->save();
        }
    }

    public function storeInResults($part, $name = 'skeleton')
    {
        CER::create([
            'course_evaluation_id' => $this->eval->id,
            'dept' => $name,
            'value' => gettype($part) != 'string' ? json_encode($part) : $part
        ]);
    }

    public function storePart($part)
    {
        $types = ['lab', 'section', 'course'];
        $flag = true;
        
        foreach ($types as $type) {
            if ($part['type'] == $type) {
                $functionName = $type . 'ResultsStore';
                $this->$functionName($part);
                $flag = false;
                break;
            }
        }

        if ($flag) {
            $this->storeInResults(base64_decode($part['data']), $part['dept']);
        }
    }

    public function labResultsStore($part)
    {
        $sections = $this->findSection($part['course'], $part['dept'], $part['section'], true);

        foreach ($sections as $section) {
            $section->evaluation = base64_decode($part['data']);
            $section->save();
        }
    }

    public function sectionResultsStore($part)
    {
        $section = $this->findSection($part['course'], $part['dept'], $part['section']);
        $section->evaluation = base64_decode($part['data']);
        $section->save();
    }

    public function courseResultsStore($part)
    {
        $course = $this->findOffered($part['course'], $part['dept']);
        $course->evaluation = base64_decode($part['data']);
        $course->save();
    }

    public function findCourse($code, $provider)
    {
        $course = Course::getCourse($code, $provider)->first();

        if (is_null($course)) {
            $course = Course::create(['code' => $code, 'provider' => $provider, 'title' => '']);
        }

        return $course;
    }

    public function findOffered($code, $provider)
    {
        $course = $this->findCourse($code, $provider);
        $offered = $course->offered;

        if (count($offered) != 0) {
            $offered = $offered->where('run_id', $this->year . '_' . ucfirst($this->semester))->first();
            
            if (!is_null($offered)) {
                return $offered;
            }
        }

        return OC::create(['course_id' => $course->id, 'run_id' => $this->year . '_' . ucfirst($this->semester)]);
    }

    public function findSection($code, $provider, $sec, $lab = false)
    {
        $offered = $this->findOffered($code, $provider);
        $section = $offered->sections;

        if ($lab) {
            return $this->findLab($offered, $sec);
        } else {
            return $this->findTheory($offered, $sec);
        }
    }

    public function findTheory($offered, $sec)
    {
        $section = $offered->sections;

        if (count($section) != 0) {
            $section = $section->where('section', $sec)->where('is_lab_faculty', false)->first();

            if (!is_null($section)) {
                return $section;
            }
        }
        
        return OCS::create(['offered_course_id' => $offered->id, 'section' => $sec, 'is_lab_faculty' => false]);
    }

    public function findLab($offered, $sec)
    {
        $sections = $offered->sections->where('offered_course_id', true)->where('section', $sec == 'undefined' ? 0 : $sec);
    
        if (count($sections) == 0) {
            if ($sec != 'undefined') {
                OCS::create(['offered_course_id' => $offered->id, 'section' => $sec, 'is_lab_faculty' => true]);
                OCS::create(['offered_course_id' => $offered->id, 'section' => $sec, 'is_lab_faculty' => true]);
            } else {
                OCS::create(['offered_course_id' => $offered->id, 'section' => 0, 'is_lab_faculty' => true]);
            }
        }

        return OCS::where('is_lab_faculty', true)->where('section', $sec)->where('offered_course_id', $offered->id)->get();
    }
}