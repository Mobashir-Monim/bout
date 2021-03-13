<?php

namespace App\Helpers\EnterprisePartHelpers;

use App\Helpers\Helper;
use App\Models\User;
use DB;

class FindMembers extends Helper
{
    protected $part;

    public function __construct($part)
    {
        $this->part = $part;
    }

    public function membersWithRole($role)
    {
        $instances = DB::table('role_user')
                        ->where('role_id', $role->id)
                        ->where('enterprise_part_id', $this->part->id)
                        ->get()->pluck('user_id')->toArray();

        return User::whereIn('id', $instances)->get();
    }

    public function allMembers()
    {
        $instances = DB::table('role_user')
                        ->where('enterprise_part_id', $this->part->id)
                        ->get()->pluck('user_id')->toArray();

        return User::whereIn('id', $instances)->get();
    }
}