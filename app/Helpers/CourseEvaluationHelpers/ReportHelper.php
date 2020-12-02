<?php

namespace App\Helpers\CourseEvaluationHelpers;

use App\Helpers\Helper;
use App\Models\CourseEvaluation as CE;
use App\Models\OfferedCourse as OC;
use App\Models\OfferedCourseSection as OCS;

class ReportHelper extends Helper
{
    public $eval = null;
    public $year = null;
    public $semester = null;
    public $results = null;
    public $data = null;

    public function __construct($year, $semester)
    {
        $this->year = $year;
        $this->semester = $semester;
        $this->eval = CE::find("$year-$semester");
        $this->results = $this->getResults();
        $this->data = $this->getReports();
    }

    public function getReports()
    {
        if ($this->isReportable()) {
            if (auth()->user()->isHead) {
                return $this->generateReports();
                return $this->generateReportFilter();
            } else {
                return $this->generateReports();
            }
        }

        return ['available' => false];
    }

    public function getResults()
    {
        if ($this->isReportable()) {
            return $this->eval->compiledResults;
        }

        return null;
    }

    public function isReportable()
    {
        if ($this->isPublishable()) {
            if ($this->eval->is_published) {
                return true;
            }
        }

        return false;
    }

    public function isPublishable()
    {
        if (!is_null($this->eval)) {
            if (!is_null($this->eval->factors)) {
                if (sizeof((array) $this->eval->compiledMatrices) > 0) {
                    if (sizeof((array) $this->eval->compiledResults) > 0) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    public function generateReports()
    {
        $obj = [];
        
        foreach (OCS::whereIn('offered_course_id', OC::where('run_id', $this->year . '_' . ucfirst($this->semester))->get()->pluck('id')->toArray())->where('email', auth()->user()->email)->get() as $key => $ocs) {
            $ocsi = $ocs->sectionDetails;
            if($this->validateResultExistance($ocsi)) {
                $this->keyCheck($ocsi['dept'], $obj);
                $this->keyCheck($ocsi['code'], $obj[$ocsi['dept']]);
                $this->keyCheck('title', $obj[$ocsi['dept']][$ocsi['code']], $ocsi['title']);
                $this->keyCheck('labs', $obj[$ocsi['dept']][$ocsi['code']]);
                $this->keyCheck('sections', $obj[$ocsi['dept']][$ocsi['code']]);
                $obj[$ocsi['dept']][$ocsi['code']][$ocsi['is_lab'] ? 'labs' : 'sections'][] = $ocsi['section'];
            }
        }

        return ['available' => true, 'type' => 'reports', 'reports' => $obj];
    }

    public function keyCheck($key, &$obj, $val = null)
    {
        if (!array_key_exists($key, $obj)) {
            if (!is_null($val)) {
                $obj[$key] = $val;
            } else {
                $obj[$key] = [];
            }
        }
    }

    public function validateResultExistance(&$ocsi)
    {
        $course = substr($ocsi['code'], 0, 6); $undefined = 'undefined'; $null = 'null';

        if (property_exists($this->results, $ocsi['dept'])) {
            if (property_exists($this->results->$ocsi['dept']->courses, $course)) {
                if ($ocsi['is_lab']) {
                    return property_exists($this->results->$ocsi['dept']->courses->$course->labs, $ocsi['section'])
                        || property_exists($this->results->$ocsi['dept']->courses->$course->labs, $undefined)
                        || property_exists($this->results->$ocsi['dept']->courses->$course->labs, $null);
                } else {
                    return property_exists($this->results->$ocsi['dept']->courses->$course->sections, $ocsi['section']);
                }
            }
        }

        return false;
    }

    public function buildRoute($dept = null, $course = null, $section = null, $lab = false)
    {
        if ($lab) {
            return route('eval-report.lab', ['year' => $this->year, 'semester' => $this->semester, 'department' => $dept, 'course' => $course, 'section' => $section]);
        } elseif (!is_null($section)) {
            return route('eval-report.section', ['year' => $this->year, 'semester' => $this->semester, 'department' => $dept, 'course' => $course, 'section' => $section]);
        } elseif (!is_null($course)) {
            return route('eval-report.course', ['year' => $this->year, 'semester' => $this->semester, 'department' => $dept, 'course' => $course]);
        } elseif (!is_null($dept)) {
            return route('eval-report.department', ['year' => $this->year, 'semester' => $this->semester, 'department' => $dept]);
        } else {
            return route('eval-report', ['year' => $this->year, 'semester' => $this->semester]);
        }
    }

    public function encrypt($key, $string)
    {
        $output = false;
        $iv = md5(md5($key));
        $output = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, $iv);
        $output = base64_encode($output);

        return $output;
    }

    public function decrypt($key, $string)
    {
        $output = false;
        $iv = md5(md5($key));
        $output = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($string), MCRYPT_MODE_CBC, $iv);
        $output = rtrim($output, "");

        return $output;
    }
}