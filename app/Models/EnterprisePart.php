<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnterprisePart extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function head()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function children()
    {
        return $this->belongsToMany('App\Models\EnterprisePart','enterprise_part_relationships', 'parent_id', 'child_id');
    }

    public function parents()
    {
        return $this->belongsToMany('App\Models\EnterprisePart','enterprise_part_relationships', 'child_id', 'parent_id');
    }

    public function getHasChildrenAttribute()
    {
        return count($this->children) > 0;
    }

    public function getHasParentsAttribute()
    {
        return count($this->parents) > 0;
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'enterprise_part_user', 'enterprise_part_id', 'user_id');
    }
}
