<?php

namespace App\Helpers\CourseEvaluationAnalysisHelpers;

use App\Helpers\Helper;

class ChartBuilder extends Helper
{
    protected $factors;
    public $chart_config = [
        'type' => 'bar',
        'data' => [],
        'options' => [
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                    'align' => 'start'
                ],
                'title' => [
                    'display' => true,
                    'text' => ''
                ]
            ]
        ]
    ];

    public function __construct($cats, $labels, $factors, $type = 'radar', $title = '')
    {
        $this->factors = $factors;
        $this->chart_config['type'] = $type;
        $this->chart_config['options']['plugins']['title']['text'] = $title;
        $this->buildConfigDataObject($cats, $labels);
    }

    public function buildConfigDataObject($cats, $labels)
    {
        $this->chart_config['data'] = [
            'labels' => $labels,
            'datasets' => [],
        ];

        $this->buildDatasets($this->stripDeptCats($cats));
    }

    public function stripDeptCats($cats)
    {
        $ds_cats = [];

        foreach ($cats as $id => $cat_vals) {
            foreach ($cat_vals as $cat => $val) {
                if (array_key_exists($cat, $this->factors)) {
                    if (!array_key_exists($cat, $ds_cats)) {
                        $ds_cats[$cat] = [];
                    }
    
                    $ds_cats[$cat][$id] = $val;
                }
            }
        }

        return $ds_cats;
    }

    public function buildDatasets($stripped_cats)
    {   
        foreach ($stripped_cats as $cat => $values) {
            $color = $this->getRandomColor();

            $this->chart_config['data']['datasets'][] = [
                'label' => $this->factors[$cat]['name'],
                'data' => [],
                'fill' => true,
                'backgroundColor' => $this->generateRGBAArray($color, 0.2),
                'borderColor' => $this->generateRGBAArray($color),
                'pointBackgroundColor' => $this->generateRGBAArray($color, 0.5),
                'pointBorderColor' => '#fff',
                'pointHoverBackgroundColor' => '#fff',
                'pointHoverBorderColor' => $this->generateRGBAArray($color, 0.5)
            ];

            foreach ($values as $dept => $value)
                $this->chart_config['data']['datasets'][sizeof($this->chart_config['data']['datasets']) - 1]['data'][] = $value;
        }
    }

    public function getRandomColor()
    {
        $hexVals = "0123456789abcdef";
        $hex = '';

        for( $i=0; $i<6; $i++ ) {
            $hex .= $hexVals[rand(0, strlen($hexVals) - 1)];
        }

        list($r, $g, $b) = array_map('hexdec', str_split($hex, 2));

        return json_decode(json_encode(['r' => $r, 'g' => $g, 'b' => $b]));
    }

    public function generateRGBAArray($color, $a = 1)
    {
        return "rgba($color->r, $color->g, $color->b, $a)";
    }

    public function getChartConfig($encode = true)
    {
        return $encode ? json_encode($this->chart_config) : $this->chart_config;
    }
}