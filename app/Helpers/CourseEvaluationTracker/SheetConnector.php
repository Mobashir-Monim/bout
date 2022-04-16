<?php

namespace App\Helpers\CourseEvaluationTracker;

use \Google_Client;
use \Google_Service_Sheets;
use App\Helpers\Helper;
use App\Models\EvalTracker;
use App\Models\OfferedCourseSection as OCS;

class SheetConnector extends Helper
{
    public $trackerDetails;
    private $metaDetails;
    private $client;
    private $sheetService;
    public $theoryData;
    public $labData;
    public $section;
    private $keyPairing = [];
    public $collated;

    public function __construct($course_evaluation_id, $section)
    {
        $this->setTrackerDetails($section);
        $this->setTrackerMeta($course_evaluation_id);
        $this->setGoogleClient();
        $this->fetchResponseData();
    }

    public function setTrackerDetails($section)
    {
        $this->section = OCS::find($section);
        $this->trackerDetails = [
            'provider' => $this->section->sectionOf->course->provider,
            'has_lab' => $this->section->sectionOf->has_lab,
            'is_lab' => $this->section->sectionOf->is_lab,
        ];
    }

    public function setTrackerMeta($course_evaluation_id)
    {
        $tracker = EvalTracker::where('course_evaluation_id', $course_evaluation_id)->first();
        $this->metaDetails = array_filter($tracker->meta, function ($val) {
            return $val['department'] == $this->trackerDetails['provider'];
        })[0];
    }

    public function setGoogleClient()
    {
        $this->client = new Google_Client();
        $this->client->setAuthConfig(config('gapi.cred'));
        $this->client->addScope("https://www.googleapis.com/auth/spreadsheets");
        $this->sheetService = new Google_Service_Sheets($this->client);
    }

    public function fetchResponseData()
    {
        $responses = [];

        if (!$this->section->sectionOf->is_lab)
            $responses['theory'] = $this->readRanges('theory');

        if ($this->section->sectionOf->has_lab)
            $responses['lab'] = $this->readRanges('lab');

        $this->collated = $this->collateResponses($responses);
    }

    public function readRanges($part)
    {
        $ranges = [];
        $i = 0;

        foreach ($this->metaDetails[$part] as $key => $item) {
            if ($key !== 'sheet') {
                $this->keyPairing[$key] = $i;
                $ranges[] = $item['range'];
                $i++;
            }
        }

        return $this->sheetService
            ->spreadsheets_values
            ->batchGet($this->metaDetails[$part]['sheet'], ['ranges' => $ranges]);
    }

    public function collateResponses($responses)
    {
        $collated = [];
        
        foreach ($responses as $key => $response) {
            $temp = [];
            $collated[$key] = [
                'emails' => array_map(function ($x) { return $x[0]; }, $response[$this->keyPairing['email']]->values),
                'courses' => array_map(function ($x) { return $x[0]; }, $response[$this->keyPairing['course']]->values),
                'sections' => array_map(function ($x) { return $x[0]; }, $response[$this->keyPairing['section']]->values)
            ];

            
            for ($i = 0; $i < sizeof($collated[$key]['emails']); $i++) {
                $temp[] = [
                    'email' => $collated[$key]['emails'][$i],
                    'course' => $collated[$key]['courses'][$i],
                    'section' => $collated[$key]['sections'][$i],
                ];
            }

            $collated[$key] = $temp;
            
        }

        return $collated;
    }
}