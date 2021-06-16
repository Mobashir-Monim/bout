<?php

namespace App\Helpers\FacultyInfoHelpers\AnnouncementHelpers;

use App\Helpers\Helper;
use App\Models\Announcement;
use Carbon\Carbon;

class Index extends Helper
{
    protected $member_of;
    protected $parts = [null];
    protected $now;
    protected $keywords;

    public function __construct($search_phrase = null)
    {
        $this->now = Carbon::now();
        $parts = [auth()->user()->hasRole('dco%'), auth()->user()->hasRole('faculty%'), auth()->user()->hasRole('announcement-author%')];

        foreach ($parts as $part) {
            if (gettype($part) != 'boolean') {
                foreach ($part as $ep) {
                    $this->parts[] = $ep;
                }
            }
        }

        $this->parts = array_unique($this->parts);
        $this->keywords = $this->parseSearchPhrase($search_phrase);
    }

    public function parseSearchPhrase($search_phrase)
    {
        if (!is_null($search_phrase)) {
            $search_phrase = str_replace(",", "", $search_phrase);
            $this->keywords = explode(" ", $search_phrase);

            foreach ($this->keywords as $key => $value)
                $this->keywords[$key] = str_replace(" ", "", $value);
        }
    }

    public function findAnnouncements()
    {
        $parts = $this->parts;
        $query = Announcement::
            where('valid_till', '>=', $this->now)->
            where(function($query) use($parts) {
                foreach($parts as $part) {
                    $query->orWhereJsonContains('enterprise_parts', $part);
                }
            });

        if (!is_null($this->keywords)) {
            $keywords = $this->keywords;
            $query = $query->where(function($query) use($keywords) {
                foreach($parts as $part) {
                    $query->orWhereJsonContains('keywords', $part);
                }
            });
        }

        return $query->orderBy('created_at', 'desc')->paginate(10);
    }
}