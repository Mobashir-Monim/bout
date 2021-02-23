<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    use \App\Models\Concerns\UsesUuid;

    protected $guarded = [];
    public $incrementing = false;

    public function maps()
    {
        return $this->hasMany('App\Models\StudentMap');
    }

    public function getUsisEmailsAttribute()
    {
        $emails = "";
        // $rows = $this->maps->where('email', 'not like', '%@g.bracu.ac.bd');
        $rows = \DB::table('student_maps')->where('student_id', $this->attributes['id'])->where('email', 'not like', '%@g.bracu.ac.bd')->get();

        for ($i = 0; $i < count($rows); $i++) {
            if ($i + 1 == count($rows)) {
                $emails .= $rows[$i]->email;
            } else {
                $emails .= $rows[$i]->email . ", ";
            }
        }

        return $emails;
    }

    public function getGsuiteEmailAttribute()
    {
        $emails = "";
        // $rows = $this->maps->where('email', 'like', '%@g.bracu.ac.bd');
        $rows = \DB::table('student_maps')->where('student_id', $this->attributes['id'])->where('email', 'like', '%@g.bracu.ac.bd')->get();

        for ($i = 0; $i < count($rows); $i++) {
            if ($i + 1 == count($rows)) {
                $emails .= $rows[$i]->email;
            } else {
                $emails .= $rows[$i]->email . ", ";
            }
        }

        return $emails;
    }
}
