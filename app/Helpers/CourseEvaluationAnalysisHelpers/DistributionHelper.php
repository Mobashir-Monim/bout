<?php

namespace App\Helpers\CourseEvaluationAnalysisHelpers;

use App\Helpers\Helper;
use App\Models\CourseEvaluation as CE;
use App\Models\CourseEvaluationResult as CER;

class DistributionHelper extends Helper
{
    public $skeleton;
    public $dist_helper;
    public $run;
    public $dist_type;
    public $chart_type;
    public $dept;
    public $course;
    public $section;
    public $semester;
    public $year;
    public $dist_view;
    public $chart_helper;
    public $dist_types = [
        'dept-comparison' => 'Department Scores Distribution',
        'course-overall-score-distribution' => 'Course Score Distribution',
        'section-score-distribution' => 'Section Score Distribution'
    ];

    public function __construct(
        $dist_type,
        $semester,
        $year,
        $chart_type = 'radar',
        $dept = null,
        $course = null,
        $section = null
    )
    {
        $this->semester = $semester;
        $this->year = $year;
        $this->dist_type = $dist_type;
        $this->run = $year . "_" . ucfirst($semester);
        $this->chart_type = $chart_type;
        $this->dept = $dept;
        $this->course = $course;
        $this->section = $section;
        $this->buildChartConfig($dist_type);
        $this->setSkeleton();
    }

    public function buildChartConfig($dist_type)
    {
        $this->buildDistHelper($dist_type);
        $this->chart_helper = new ChartBuilder(
            $this->dist_helper->getCats(),
            $this->dist_helper->getLables(),
            json_decode(CE::find($this->run)->factors, true),
            $this->chart_type,
            $this->dist_helper->title
        );
    }

    public function buildDistHelper($dist_type)
    {
        if ($dist_type == 'dept-comparison') {
            $this->dist_view = 'eval-analysis.parts.dept-comparison';
            $this->dist_helper = new DeptComparison($this->run);
        } elseif ($dist_type == 'course-overall-score-distribution') {
            $this->dist_view = 'eval-analysis.parts.course-comparison';
            $this->dist_helper = new CoursesDistribution($this->run, $this->dept);
        } else {
            $this->dist_view = 'eval-analysis.parts.section-comparison';
            $this->dist_helper = new SectionsDistribution($this->run, $this->dept, $this->course);
        }
    }

    public function getChartConfig($encode = true)
    {
        return $this->chart_helper->getChartConfig($encode);
    }

    public function getDistTypes()
    {
        $types = [];
        $types[$this->dist_type] = $this->dist_types[$this->dist_type];

        foreach ($this->dist_types as $key => $value) {
            if ($this->dist_type != $key) {
                $types[$key] = $value;
            }
        }

        return $types;
    }

    public function setSkeleton()
    {
        $permissions = new PermissionsBuilder($this->run);
        $this->skeleton = $permissions->skeleton;
    }

    public function hasPermission()
    {
        if (array_key_exists($this->dept, $this->skeleton)) {
            if (!is_null($this->course)) {
                if (array_key_exists($this->course, $this->skeleton[$this->dept])) {
                    return true;
                }
            } else {
                return true;
            }
        }

        return false;
    }
}