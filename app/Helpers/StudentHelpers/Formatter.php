<?php

namespace App\Helpers\StudentHelpers;

use App\Helpers\Helper;

class Formatter extends Helper
{
    protected $passed_data = [];
    protected $searchable = [];
    protected $instances = [];
    
    public function __construct($id, $emails, $org_emails, $details)
    {
        $this->setPassedData($id, $this->parseEmail($emails), $this->parseEmail($org_emails), $details);
        $this->setSearchable($id, $this->parseEmail($emails), $this->parseEmail($org_emails));
        $this->findInstances();
    }

    public function parseEmail($emails)
    {
        $emails = explode(',', str_replace(' ', '', $emails));
        $emails = array_filter($emails, fn($emails) => !is_null($email) && $email !== '');

        return $emails;
    }

    public function setPassedData($id, $emails, $org_emails, $details)
    {
        $this->passed_data[$id] = ['details' => $details, 'emails' => []];
        
        foreach ($emails as $email)
            $this->passed_data[$id]['emails'][] = $email;

        foreach ($org_emails as $email)
            $this->passed_data[$id]['emails'][] = $email;
    }

    public function setSearchable($id, $emails, $org_emails)
    {
        $this->searchable[] = $id;

        foreach ($emails as $email)
            $this->searchable[] = $email;

        foreach ($org_emails as $email)
            $this->searchable[] = $email;
    }

    public function findInstances()
    {
        foreach ($this->searchable as $search_item) {
            $student = (new Search($search_item))->students[0];

            if (!array_key_exists($student->id, $this->instances))
                $this->instances[$student->id] = ['details' => $this->stripDetails($student), 'emails' => $this->stripEmails($student)];
        
        }
    }

    public function stripDetails($student)
    {
        return [
            'name' => $student->name,
            'program' => $student->program,
            'department' => $student->department,
            'school' => $student->school
        ];
    }

    public function stripEmails($student)
    {
        $emails = [];

        foreach ($student->maps as $map)
            $emails[] = ['email' => $map->email, 'username' => $map->username, 'id' => $map->id];
    
        return $emails;
    }

    public function getInstances()
    {
        return $this->instances;
    }

    public function getPassedData()
    {
        return $this->passed_data;
    }
}