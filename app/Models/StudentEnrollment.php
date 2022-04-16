<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentEnrollment extends Model
{
    use HasFactory;
    use \App\Models\Concerns\UsesUuid;
    
    protected $guarded = [];

    public function section()
    {
        return $this->belongsTo(OfferedCourseSection::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function offeredCourse()
    {
        return $this->section->sectionOf;
    }

    public function course()
    {
        return $this->offeredCourse->course;
    }
}
