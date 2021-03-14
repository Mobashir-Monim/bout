<?php

namespace App\Helpers\RoleHelpers;

use App\Helpers\Helper;
use App\Models\Role;
use App\Models\EnterprisePart;
use DB;

class FindInstances extends Helper
{
    protected $role = null;
    protected $part = null;
    protected $user = null;
    protected $search_type = 0;

    public function __construct($conf_arr)
    {
        if (array_key_exists('role', $conf_arr)) {
            $this->role = $conf_arr['role'];
            $this->search_type += 1;
        }

        if (array_key_exists('part', $conf_arr)) {
            $this->part = $conf_arr['part'];
            $this->search_type += 10;
        }

        if (array_key_exists('user', $conf_arr)) {
            $this->user = $conf_arr['user'];
            $this->search_type += 100;
        }
    }

    public function search()
    {
        if ($this->search_type < 10) {
            return $this->roleBasedSeach();
        } elseif ($this->search_type < 100) {
            return $this->enterprisePartBasedSearch();
        } else {
            return $this->userBasedSearch();
        }
    }

    public function roleBasedSeach()
    {
        if ($this->search_type == 0) {
            return DB::table('role_user')->all();
        } else {
            return DB::table('role_user')
                        ->where('role_id', $this->role->id)
                        ->get();
        }
    }

    public function enterprisePartBasedSearch()
    {
        if ($this->search_type == 10) {
            return DB::table('role_user')
                        ->where('part_id', $this->part->id)
                        ->get();
        } else {
            return DB::table('role_user')
                        ->where('part_id', $this->part->id)
                        ->where('role_id', $this->role->id)
                        ->get();
        }
    }

    public function userBasedSearch()
    {
        if ($this->search_type == 100) {
            return DB::table('role_user')
                        ->where('user_id', $this->user->id)
                        ->get();
        } elseif ($this->search_type == 101) {
            return DB::table('role_user')
                        ->where('role_id', $this->role->id)
                        ->where('user_id', $this->user->id)
                        ->get();
        } elseif ($this->search_type == 110) {
            return DB::table('role_user')
                        ->where('part_id', $this->part->id)
                        ->where('user_id', $this->user->id)
                        ->get();
        } else {
            return DB::table('role_user')
                        ->where('role_id', $this->role->id)
                        ->where('part_id', $this->part->id)
                        ->where('user_id', $this->user->id)
                        ->get();
        }
    }
}