<?php

namespace App\Helpers\CourseEvaluationHelpers;

use App\Helpers\Helper;
use App\Models\EnterprisePart as EP;
use App\Models\CourseEvaluation as CE;
use App\Models\OfferedCourse as OC;
use App\Models\OfferedCourseSection as OCS;

class ReportHelper extends Helper
{
    public $eval = null;
    public $year = null;
    public $semester = null;
    public $results = [];
    public $data = null;
    public $report = null;
    public $userPermissions = ['isHead' => false, 'filter' => false, 'dept-report' => false, 'course-report' => false, 'section-report' => false, 'lab-report' => false];

    public function __construct($year, $semester, $faculty_filter = false)
    {
        $this->year = $year;
        $this->semester = $semester;
        $this->eval = CE::find($year . "_" . ucfirst($semester));
        $this->contructPermissions();
        $this->getReports();
        
        if (!$faculty_filter) {
            $this->buildFormulaHelper();
        }
    }

    public function contructPermissions()
    {
        $user = auth()->user();

        $this->userPermissions = [
            'isHead' => $user->isHead,
            'filter' => $user->hasPermission('course-evaluation', 'filter'),
            'dept-report' => $user->hasPermission('course-evaluation', 'dept-report'),
            'course-report' => $user->hasPermission('course-evaluation', 'course-report'),
            'section-report' => $user->hasPermission('course-evaluation', 'section-report'),
            'lab-report' => $user->hasPermission('course-evaluation', 'lab-report')
        ];
    }

    public function getReports()
    {
        if ($this->isReportable()) {
            if ($this->userPermissions['filter']) {
                $this->generatePermissionedFilter();
            } elseif ($this->userPermissions['isHead']) {
                $this->generateReportFilter();
            } else {
                $this->generateReports();
            }
        } else {
            $this->data = ['available' => false];
        }
    }

    public function isReportable()
    {
        if ($this->isPublishable()) {
            return $this->eval->is_published;
        }

        return false;
    }

    public function isPublishable()
    {
        if (!is_null($this->eval)) {
            if (!is_null($this->eval->factors)) {
                if (sizeof((array) $this->eval->compiledMatrices) > 0) {
                    if (sizeof((array) $this->eval->deptResults()) > 0) {
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

        foreach ($this->eval->skeleton as $dept => $data) {
            if (in_array($dept, $depts)) {
                $this->results[$dept] = $data;
            }
        }
        
        $this->data = ['available' => true, 'type' => 'filter'];
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

    public function generatePermissionedFilter()
    {
        $access_list = gettype($this->userPermissions['filter']) == 'string' ?
                        EP::whereIn('id', explode(',', $this->userPermissions['filter']))->get()->pluck('name')->toArray() :
                        EP::where('is_academic_part', true)->get()->pluck('name')->toArray();

        if ($this->userPermissions['isHead']) $this->generateReportFilter();

        foreach ($this->eval->skeleton as $dept => $data) {
            if (in_array($dept, $access_list)) {
                $this->results[$dept] = $data;
            }
        }

        $this->data = ['available' => true, 'type' => 'filter'];
    }

    public function generateReports()
    {
        foreach (OCS::whereIn('offered_course_id', OC::where('run_id', $this->year . '_' . ucfirst($this->semester))->get()->pluck('id')->toArray())->where('email', auth()->user()->email)->get() as $key => $ocs) {
            $ocsi = $ocs->sectionDetails;
            if(!is_null($ocs->evaluation)) {
                $this->keyCheck($ocsi['dept'], $this->results);
                $this->keyCheck($ocsi['code'], $this->results[$ocsi['dept']]);
                $this->keyCheck('title', $this->results[$ocsi['dept']][$ocsi['code']], $ocsi['title']);
                $this->keyCheck('labs', $this->results[$ocsi['dept']][$ocsi['code']]);
                $this->keyCheck('sections', $this->results[$ocsi['dept']][$ocsi['code']]);
                $this->results[$ocsi['dept']][$ocsi['code']][$ocsi['is_lab'] ? 'labs' : 'sections'][] = $ocsi['section'];
            }
        }

        $this->data = ['available' => true, 'type' => 'reports'];
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
        return array_key_exists($dept, $this->results[]) &&
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

    public function buildDeptReport($dept)
    {
        $this->results = json_decode(json_encode($this->results), true)[$dept];
        $this->results['course_count'] = sizeof($this->results['courses']);
        $this->results['section_count'] = 0;

        foreach ($this->results['courses'] as $course) {
            $this->results['section_count'] += sizeof($course['sections']);
        }
    }

    public function buildCourseReport($dept, $course)
    {
        $this->results = json_decode(json_encode($this->results), true)[$dept]['courses'][$course];
    }

    public function buildSectionReport($dept, $course, $section, $lab = false)
    {
        $this->buildCourseReport($dept, $course);
        $this->results[$lab ? 'labs' : 'sections'][$section]['name'] = "$course - $section";
        $this->results = $this->results[$lab ? 'labs' : 'sections'][$section];
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

    public function buildFormulaHelper()
    {
        $this->formulaHelper = new FormulaHelper($this->eval);

        if (sizeof($this->formulaHelper->access_list) == 0) {
            $this->formulaHelper = null;
        } else {
            $this->formulaHelper->factorShorts = array_keys($this->formulaHelper->factors);
            usort($this->formulaHelper->factorShorts, function ($a, $b) { return strlen($b) - strlen($a); });
            $this->formulaHelper->factorShorts = json_encode($this->formulaHelper->factorShorts);
        }
    }
}