<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnterprisePart extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function children()
    {
        return $this->belongsToMany('App\Models\EnterprisePart', 'parent_id', 'child_id');
    }

    public function parents()
    {
        return $this->belongsToMany('App\Models\EnterprisePart', 'child_id', 'parent_id');
    }
}
