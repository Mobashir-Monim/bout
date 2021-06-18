<?php

namespace App\Helpers\FacultyInfoHelpers\AnnouncementHelpers;

use App\Helpers\Helper;
use App\Models\Announcement;
use App\Models\EnterprisePart;
use Carbon\Carbon;

class Index extends Helper
{
    protected $member_of;
    protected $parts = [null];
    protected $now;
    protected $search_data = [];

    public function __construct($search_data)
    {
        $this->now = Carbon::now();
        $this->setSearchData($search_data);
        $this->setAccessibleParts();
        
    }

    public function setAccessibleParts()
    {
        $parts = [auth()->user()->hasRole('dco%'), auth()->user()->hasRole('faculty%'), auth()->user()->hasRole('announcement-author%')];

        foreach ($parts as $part) {
            if (gettype($part) != 'boolean') {
                foreach ($part as $ep)
                    $this->parts[] = $ep;
            }
        }

        if (auth()->user()->hasRole('super-admin')) {
            foreach (EnterprisePart::all() as $ep)
                $this->parts[] = $ep->id;
        }

        $this->parts = array_unique($this->parts);
    }

    public function setSearchData($search_data)
    {
        if (!is_null($search_data['search_phrase']) || $search_data['search_phrase'] != "")
            $this->parseSearchPhrase($search_data['search_phrase']);

        if (!is_null($search_data['year']) || $search_data['year'] != "")
            $this->parseRunSearch($search_data['year'], 'year');

        if (!is_null($search_data['semester']) || $search_data['semester'] != "")
            $this->parseRunSearch($search_data['semester'], 'semester');

        $this->parseValiditySearch($search_data['validity']);
    }

    public function parseSearchPhrase($search_phrase)
    {
        $this->search_data['keywords'] = [];
        $search_phrase = str_replace(",", "", $search_phrase);
        $this->search_data['keywords'] = explode(" ", $search_phrase);

        foreach ($this->search_data['keywords'] as $key => $value)
            $this->search_data['keywords'][$key] = str_replace(" ", "", $value);
    }

    public function parseRunSearch($search_value, $type)
    {
        if ($type == 'year') {
            $this->search_data['run'] = "$search_value%";
        } else {
            if (array_key_exists('run', $this->search_data)) {
                $this->search_data['run'] = str_replace("%", '_', $this->search_data['run']) . $search_value;
            } else {
                $this->search_data['run'] = "%$search_value";
            }
        }
    }

    public function parseValiditySearch($validity)
    {
        if ($validity == 'active' || is_null($validity) || $validity == '') {
            $this->search_data['validity'] = '>=';
        } elseif ($validity == 'archived') {
            $this->search_data['validity'] = '<';
        }
    }

    public function findAnnouncements()
    {
        $parts = $this->parts;
        $query = Announcement::where(function($query) use($parts) {
                foreach($parts as $part) {
                    $query->orWhereJsonContains('enterprise_parts', $part);
                }
            });

        if (array_key_exists('keywords', $this->search_data))
            $this->filterUsingKeywords($query);

        if (array_key_exists('run', $this->search_data))
            $this->filterUsingRun($query);

        if (array_key_exists('validity', $this->search_data))
            $this->filterUsingValidity($query);

        return $query->orderBy('created_at', 'desc')->paginate(5);
    }

    public function filterUsingKeywords(&$query)
    {
        $keywords = $this->search_data['keywords'];
        $query = $query->where(function($query) use($keywords) {
            foreach($keywords as $keyword) {
                $query->orWhereJsonContains('keywords', $keyword);
            }
        });
    }

    public function filterUsingRun(&$query)
    {
        $query = $query->where('run', 'like', $this->search_data['run']);
    }

    public function filterUsingValidity(&$query)
    {
        $query = $query->where('valid_till', $this->search_data['validity'], $this->now);
    }
}