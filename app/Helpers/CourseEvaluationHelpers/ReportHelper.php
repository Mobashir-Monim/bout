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
        // dd($this->data);
    }

    public function togglePublishStatus()
    {
        $this->eval->is_published = !$this->eval->is_published;
        $this->eval->save();
        $this->data = $this->getReports();
    }

    public function getReports()
    {
        if ($this->isReportable()) {
            if (auth()->user()->isHead) {
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

    public function generateReportFilter()
    {
        $depts = [];
        
        foreach (auth()->user()->headOf as $part) {
            $depts = array_unique(array_merge($depts, $this->iterateChildrenParts($part)), SORT_REGULAR);
        }
        
        return ['available' => true, 'type' => 'filter', 'depts' => $depts];
    }

    public function iterateChildrenParts($part)
    {
        if ($part->hasChildren) {
            $children = [];

            foreach ($part->children as $key => $child) {
                $children = array_unique(array_merge($children, $this->iterateChildrenParts($child)), SORT_REGULAR);
            }

            return $children;
        } else {
            return [$part->name];
        }
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

    public function createSelectionList()
    {
        $list = [];
        
        foreach ($this->data['depts'] as $dept) {
            $dept = strtoupper($dept);
            $list[$dept] = [];

            if (property_exists($this->results, $dept)) {
                foreach ($this->results->$dept->courses as $course => $courseData) {
                    $list[$dept][$course] = ['sections' => [], 'labs' => []];
    
                    foreach ($this->results->$dept->courses->$course->sections as $section => $sectionData) {
                        $list[$dept][$course]['sections'][] = $section;
                    }
    
                    foreach ($this->results->$dept->courses->$course->labs as $lab => $labData) {
                        $list[$dept][$course]['labs'][] = $lab;
                    }
                }
            }
        }

        return $list;
    }

    public function hasPermission($dept = null, $course = null, $section = null, $lab = false)
    {
        if (auth()->user()->isHead) {
            $flag = false;

            foreach (auth()->user()->headOf as $part) {
                $flag = $flag || $this->validateHeadPermission($dept, $part);
            }

            return $flag;
        } else {
            return $this->validateFacultyPermission($dept, $course, $section, $lab);
        }
    }

    public function validateHeadPermission($dept, $part)
    {
        if ($part->hasChildren) {
            $flag = false;

            foreach ($part->children as $child) {
                $flag = $flag || $this->validateHeadPermission($dept, $child);
            }

            return $flag;
        } else {
            return sizeof(preg_grep("/$part->name/i" , $this->data['depts'])) > 0;
        }
    }

    public function validateFacultyPermission($dept, $course, $section, $lab)
    {
        if (array_key_exists($dept, $this->data['reports'])) {
            if (array_key_exists($course, $this->data['reports'][$dept])) {
                return in_array($section, $this->data['reports'][$dept][$course][$lab ? 'labs' : 'sections']);
            }
        }

        return false;
    }

    public function reportExists($dept = null, $course = null, $section = null, $lab = false)
    {
        return property_exists($this->results, $dept) &&
        (!is_null($course) ? property_exists($this->results->$dept->courses, $course) : true) &&
        (!is_null($section) ? property_exists(
            ($lab ? $this->results->$dept->courses->$course->labs : $this->results->$dept->courses->$course->sections)
        , $section) : true);
    }

    public function validateReportRequest($dept = null, $course = null, $section = null, $lab = false)
    {
        if (!$this->isReportable()) {
            return ['error' => true, 'message' => 'The requested report is not available yet'];
        } elseif (!$this->reportExists($dept, $course, $section, $lab)) {
            return ['error' => true, 'message' => 'The requested report does not exist'];
        } elseif (!$this->hasPermission($dept, $course, $section, $lab)) {
            return ['error' => true, 'message' => 'You do not have view access to the requested report'];
        }

        return ['error' => false, 'message' => 'Generating report'];
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