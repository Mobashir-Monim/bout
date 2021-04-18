<?php

namespace App\Helpers\CourseEvaluationHelpers;

use App\Helpers\Helper;
use App\Models\CourseEvaluation as CE;
use App\Models\CourseEvaluationResult as CER;
use App\Models\EnterprisePart as EP;

class FormulaHelper extends Helper
{
    public $eval = null;
    public $access_list = [];
    public $userPermissions = ['isHead' => false, 'build-formula' => false, 'view-formula' => false];
    
    public function __construct($eval)
    {
        $this->eval = $eval;
        $this->factors = json_decode($eval->factors, true);
        $this->contructPermissions();
        $this->buildAccessList();
    }

    public function contructPermissions()
    {
        $user = auth()->user();

        $this->userPermissions = [
            'isHead' => $user->isHead,
            'build-formula' => $user->hasPermission('course-evaluation', 'build-formula'),
            'view-formula' => $user->hasPermission('course-evaluation', 'view-formula')
        ];
    }

    public function buildAccessList()
    {
        $this->getHeadAccessList();
        $this->getPermissionAccessList();
        $access_list = [];

        foreach (CER::where('course_evaluation_id', $this->eval->id)->get() as $cer) {
            if (array_key_exists($cer->dept, $this->access_list)) {
                $access_list[$cer->dept]['access_levels'] = $this->access_list[$cer->dept];
                $access_list[$cer->dept]['expression'] = $cer->score_expression;
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
        $this->addToAccessList($part->name, ['build-formula', 'view-formula']);

        if ($part->hasChildren) {
            foreach ($part->children as $child) {
                if (!array_key_exists($child->name, $this->access_list))
                    $this->iterateChildrenParts($child);
            }
        }
    }

    public function getPermissionAccessList()
    {
        foreach (['build-formula', 'view-formula'] as $access_level) {
            if ($this->userPermissions[$access_level]) {
                $parts = gettype($this->userPermissions[$access_level]) == 'string' ?
                    EP::whereIn('id', explode(',', $this->userPermissions[$access_level]))->get()->pluck('name')->toArray() :
                    EP::all()->pluck('name')->toArray();
    
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

    public function storeExpression($dept, $expression)
    {
        $this->status = ['error' => '', 'message' => ''];

        if ($this->hasBuildAccess($dept)) {
            $cer = CER::where('course_evaluation_id', $this->eval->id)->where('dept', $dept)->first();
            $cer->score_expression = $expression;
            $cer->save();
        }
    }

    public function hasBuildAccess($dept)
    {
        if (array_key_exists($dept, $this->access_list)) {
            if (in_array('build-formula', $this->access_list[$dept]['access_levels'])) {
                $this->setStatus(false, "Score formula for $dept updated.");

                return true;
            } else {
                $this->setStatus(true, "You do not have access to set/edit $dept's score formula.");
            }
        } else {
            $this->setStatus(true, "You do not have access to $dept.");
        }

        return false;
    }

    public function setStatus($is_error, $message)
    {
        $this->status = [
            'error' => $is_error,
            'message' => $message
        ];
    }
}