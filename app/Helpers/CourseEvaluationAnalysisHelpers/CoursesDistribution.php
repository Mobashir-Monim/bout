<?php

namespace App\Helpers\CourseEvaluationAnalysisHelpers;

use App\Helpers\Helper;
use App\Models\Course;
use App\Models\OfferedCourse as OC;

class CoursesDistribution extends Helper
{
    protected $courses = [];
    public $title = '';

    public function __construct($semester, $dept = null)
    {
        $this->semester = $semester;
        $this->dept = $dept;
        $this->setChartTitle($dept);

        if (!is_null($dept)) {
            $this->courses = OC::where('run_id', $this->semester)
                ->whereIn(
                    'course_id',
                    Course::where('provider', $this->dept)->get()
                        ->pluck('id')->toArray()
                )->get();
        } else {
            $this->courses = OC::where('run_id', $this->semester)->get();
        }
    }

    public function getLables()
    {
        $labels = [];

        for ($i = 0; $i < 100; $i += 5) { 
            $labels[] = $i . " - " . ($i + 5);
        }

        return $labels;
    }

    public function getCats()
    {
        $labels = $this->getLables();
        $cats = array_fill_keys($labels, []);

        foreach ($this->courses as $course) {
            $eval = json_decode($course->evaluation, true);
            if ($eval != null) {
                $temp = array_key_exists('cats', $eval) ? $eval['cats'] :
                    json_decode(OC::find($eval['links_to'])->evaluation, true)['cats'];

                foreach ($temp as $cat => $value) {
                    $val_class = (int) ($value / 5);
                    $val_class = $val_class == 20 ? 19 : $val_class;

                    if (!array_key_exists($cat, $cats[$labels[$val_class]])) {
                        $cats[$labels[$val_class]][$cat] = 0;
                    }

                    $cats[$labels[$val_class]][$cat] += 1;
                }
            }
        }

        return $cats;
    }

    public function setChartTitle($dept)
    {
        $this->title = is_null($dept) ? 'University wide course overall score distribution' :
            "$dept course overall score distribution";
    }
}