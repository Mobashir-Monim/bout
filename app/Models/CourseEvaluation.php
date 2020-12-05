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

    public function getCompiledMatricesAttribute()
    {
        $matrix = '';

        foreach ($this->matrices->sortBy('part') as $key => $m) {
            $matrix .= $m->value;
        }

        return $matrix == '' ? [] : json_decode($matrix);
    }

    public function getSkeletonAttribute()
    {
        return json_decode($this->results->where('dept', 'skeleton')->first()->value);
    }

    public function deptResults($dept = null)
    {
        if (is_null($dept)) {
            $results = [];
            
            foreach ($this->results->where('dept', '!=', 'skeleton') as $res) {
                $results[$res->dept] = json_decode($res->value, true);
            }
            
            return $results;
        } else {
            $res = $this->results->where('dept', $dept)->first();
            
            if (!is_null($res)) {
                return json_decode($res->value, true);
            }

            return false;
        }
    }
}
