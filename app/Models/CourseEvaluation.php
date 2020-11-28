<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseEvaluation extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $guarded = [];

    public function matrices()
    {
        return $this->hasMany('App\Models\CourseEvaluationMatrix');
    }

    public function results()
    {
        return $this->hasMany('App\Models\CourseEvaluationResult');
    }
}
