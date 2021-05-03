<?php

namespace App\Helpers\CourseEvaluationAnalysisHelpers;

use App\Helpers\Helper;
use App\Models\CourseEvaluationResult as CER;

class PermissionsBuilder extends Helper
{
    public $access_list = [];
    public $userPermissions;
    public $run;
    public $skeleton = [];

    public function __construct($run, $build_access_list = true)
    {
        $this->run = $run;
        $this->constructPermissions();
        
        if ($build_access_list) {
            $this->buildAccessList();
            $this->buildSkeleton();
        }
    }

    public function hasPermission()
    {
        foreach ($this->userPermissions as $permission)
            if ($permission)
                return true;

        return false;
    }

    public function constructPermissions()
    {
        $user = auth()->user();

        $this->userPermissions = [
            'isHead' => $user->isHead,
            'dept-report' => $user->hasPermission('course-evaluation', 'dept-report'),
            'course-report' => $user->hasPermission('course-evaluation', 'course-report'),
        ];
    }

    public function buildAccessList()
    {
        $this->getHeadAccessList();
        $this->getPermissionAccessList();
        $access_list = [];

        foreach (CER::where('course_evaluation_id', $this->run)->get() as $cer) {
            if (array_key_exists($cer->dept, $this->access_list)) {
                $access_list[$cer->dept]['access_levels'] = $this->access_list[$cer->dept];
            }
        }

        $this->access_list = $access_list;
    }

    public function getHeadAccessList()
    {
        if ($this->userPermissions['isHead']) {
            foreach (auth()->user()->headOf as $part) {
                $this->iterateChildrenParts($part);
            }
        }
    }

    public function iterateChildrenParts($part)
    {
        $this->addToAccessList($part->name, ['dept-report', 'course-report']);

        if ($part->hasChildren) {
            foreach ($part->children as $child) {
                if (!array_key_exists($child->name, $this->access_list))
                    $this->iterateChildrenParts($child);
            }
        }
    }

    public function getPermissionAccessList()
    {
        foreach (['dept-report', 'course-report'] as $access_level) {
            if ($this->userPermissions[$access_level]) {
                $parts = gettype($this->userPermissions[$access_level]) == 'string' ?
                    EP::whereIn('id', explode(',', $this->userPermissions[$access_level]))->get() :
                    EP::all();
    
                foreach ($parts as $part) {
                    $this->addToAccessList($part->name, [$access_level]);
                }
            }
        }
    }

    public function addToAccessList($dept, $access_levels)
    {
        if (array_key_exists($dept, $this->access_list)) {
            foreach ($access_levels as $access_level) {
                if (!in_array($access_level, $this->access_list[$dept]))
                    $this->access_list[$dept][] = $access_level;
            }
        } else {
            $this->access_list[$dept] = $access_levels;
        }
    }

    public function buildSkeleton()
    {
        $skeleton = json_decode(CER::where('course_evaluation_id', $this->run)->where('dept', 'skeleton')->first()->value, true);

        foreach ($this->access_list as $dept => $access_levels) {
            $this->skeleton[$dept] = [];

            if (in_array('course-report', $access_levels['access_levels'])) {
                $this->skeleton[$dept] = $skeleton[$dept];
            }
        }
    }
}