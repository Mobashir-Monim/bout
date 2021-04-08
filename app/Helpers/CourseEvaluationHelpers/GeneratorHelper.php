<?php

namespace App\Helpers\CourseEvaluationHelpers;

use App\Helpers\Helper;
use App\Models\CourseEvaluation as CE;
use App\Models\Course;
use App\Models\OfferedCourse as OC;
use App\Models\OfferedCourseSection as OCS;
use App\Models\EnterprisePart as EP;

class GeneratorHelper extends Helper
{
    public $eval = null;
    public $year = null;
    public $semester = null;
    public $status = null;
    public $report = null;
    public $dept = null;
    public $course = null;
    public $section = null;
    public $lab = null;
    public $accessList = [];
    public $userPermissions = ['isHead' => false, 'dept-report' => false, 'course-report' => false, 'section-report' => false, 'lab-report' => false];


    public function __construct($year, $semester, $dept = null, $course = null, $section = null, $lab = false)
    {
        $this->year = $year;
        $this->semester = $semester;
        $this->eval = CE::find($year . "_" . ucfirst($semester));
        $this->dept = $dept; $this->course = $course; $this->section = $section; $this->lab = $lab;
        $this->contructPermissions();

        if (is_null($this->eval)) {
            $this->status = ['error' => true, 'message' => 'The requested report is not available/has not been published yet'];
        } else {
            $this->validateRequest();
        }
    }

    public function contructPermissions()
    {
        $user = auth()->user();

        $this->userPermissions = [
            'isHead' => $user->isHead,
            'dept-report' => $user->hasPermission('course-evaluation', 'dept-report'),
            'course-report' => $user->hasPermission('course-evaluation', 'course-report'),
            'section-report' => $user->hasPermission('course-evaluation', 'section-report'),
            'lab-report' => $user->hasPermission('course-evaluation', 'lab-report')
        ];
    }

    public function validateRequest()
    {
        if ($this->eval->is_published) {
            if ($this->reportExists()) {
                if (!$this->hasPermission()) {
                    $this->status = ['error' => true, 'message' => 'You do not have view access to the requested report'];
                } else {
                    $this->status = ['error' => false];
                    $this->report = gettype($this->report) == 'string' ? json_decode($this->report, true) : $this->report;
                    $this->checkLinkedEval();
                }
            } else {
                $this->status = ['error' => true, 'message' => 'The requested report does not exist'];
            }
        } else {
            $this->status = ['error' => true, 'message' => 'The requested report is not available/has not been published yet'];
        }
    }

    public function reportExists()
    {
        if (is_null($this->course) && is_null($this->section)) {
            $this->report = $this->eval->deptResults($this->dept);
            
            return gettype($this->report) != 'boolean';
        }

        $this->report = OC::whereIn('course_id', Course::where('code', $this->course)->where('provider', $this->dept)->get()->pluck('id')->toArray())->where('run_id', $this->eval->id)->first();
        
        if (!is_null($this->report)) {
            $this->accessList[] = $this->report->email;

            if (count($this->report->sections) == 0) {
                return false;
            } else {
                $this->accessList = array_merge($this->accessList, $this->report->sections->pluck('email')->toArray());
            }
        } else {
            return false;
        }

        if (is_null($this->section)) {
            if (is_null($this->report)) {
                return false;
            }

            $this->report = $this->report->evaluation;

            return !is_null($this->report);
        } else {
            $this->report = OCS::where('offered_course_id', $this->report->id)->where('section', $this->section)->where('is_lab_faculty', $this->lab)->whereNotNull('evaluation')->get();

            return count($this->report) > 0;
        }
    }

    public function hasPermission()
    {
        if ($this->checkPermissions()) {
            return true;
        }

        if ($this->userPermissions['isHead']) {
            foreach (auth()->user()->headOf as $part) {
                if ($this->iterateChildrenParts($part)) {
                    return true;
                }
            }

            return false;
        } else {
            try {
                return $this->validateFacultyRequest();
            } catch (\Throwable $th) {
                return in_array(auth()->user()->email, $this->accessList);
            }
        }
    }

    public function iterateChildrenParts($part)
    {
        if ($part->name == $this->dept) {
            return true;
        }

        if ($part->hasChildren) {
            foreach ($part->children as $child) {
                if ($this->iterateChildrenParts($child)) {
                    return true;
                }
            }
        }

        return false;
    }

    public function validateFacultyRequest()
    {
        if (!is_null($this->section)) {
            $this->report = $this->report->where('email', auth()->user()->email)->first();

            if (!is_null($this->report)) {
                $this->report = $this->report->evaluation;
                return true;
            }
        } elseif (!is_null($this->course)) {
            if (count($this->report->sections->where('lab', false)->where('email', auth()->user()->email)) > 0) {
                $this->report = $this->report->evaluation;
            }
        }

        return false;
    }

    public function checkPermissions()
    {
        if (is_null($this->section) && is_null($this->course)) {
            return $this->checkPartWisePermission('dept-report');
        } elseif (is_null($this->section)) {
            return $this->checkPartWisePermission('course-report');
        } elseif (!$this->lab) {
            $this->report = json_decode($this->report->first()->evaluation, true);
            
            return $this->checkPartWisePermission('section-report');
        } elseif ($this->lab) {
            $this->report = json_decode($this->report->first()->evaluation, true);

            return $this->checkPartWisePermission('lab-report');
        }

        return false;
    }

    public function checkPartWisePermission($type)
    {
        if (gettype($this->userPermissions[$type]) != 'string') {
            return $this->userPermissions[$type];
        }

        return in_array(
            $this->dept,
            EP::whereIn('id', explode(',', $this->userPermissions[$type]))->get()->pluck('name')->toArray()
        );
    }

    public function checkLinkedEval()
    {
        if (gettype($this->report) == 'array') {
            if (array_key_exists('links_to', $this->report)) {
                if (is_null($this->section)) {
                    $this->report = json_decode(OC::find($this->report['links_to'])->evaluation, true);
                } else {
                    $this->report = json_decode(OCS::find($this->report['links_to'])->evaluation, true);
                }
            }
        }
    }
}