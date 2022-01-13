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
        $rows = \DB::table('student_maps')->where('student_id', $this->attributes['id'])->where('email', 'not like', '%@g.bracu.ac.bd')->get()->pluck('email')->toArray();

        return $implode ? implode(", ", $rows) : $rows;
    }

    public function getGsuiteEmailsAttribute()
    {
        $rows = \DB::table('student_maps')->where('student_id', $this->attributes['id'])->where('email', 'like', '%@g.bracu.ac.bd')->get()->pluck('email')->toArray();

        return $implode ? implode(", ", $rows) : $rows;
    }
}
