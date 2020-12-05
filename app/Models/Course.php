<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    use \App\Models\Concerns\UsesUuid;

    protected $guarded = [];

    public function offered()
    {
        return $this->hasMany('App\Models\OfferedCourse', 'course_id');
    }

    public static function getCourse($code = null, $provider = null)
    {
        if (is_null($code)) {
            return self::where('provider', $provider)->get();
        } elseif (is_null($provider)) {
            return self::where('code', $code)->get();
        }

        return self::where('code', $code)->where('provider', $provider)->get();
    }
}
