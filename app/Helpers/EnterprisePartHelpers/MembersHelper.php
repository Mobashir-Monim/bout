<?php

namespace App\Helpers\EnterprisePartHelpers;

use App\Helpers\Helper;
use App\Models\User;
use App\Models\Role;
use DB;

class MembersHelper extends Helper
{
    protected $part;
    protected $member;

    public function __construct($part, $member)
    {
        $this->part = $part;
        $this->member = $this->findMember($member);
    }

    public function findMember($email)
    {
        $user = User::where('email', $email)->first();

        if (is_null($user)) {
            $user = User::create(['name' => ' ', 'email' => $email, 'password' => bcrypt('pass')]);
        }

        return $user;
    }

    public function changeHead()
    {
        $this->part->user_id = $this->member->id;
        $this->part->save();
    }

    public function removeDCO()
    {
        $this->member->roles()->detach(Role::where('name', 'dco')->first()->id);
        $this->removeMember();
    }

    public function addDCO()
    {
        $role = Role::where('name', 'dco')->first();

        if (!$this->hasRoleInPart($role)) {
            $this->addRole($role);
        }
    }

    public function removeMember()
    {
        $role = Role::where('name', 'faculty')->first();

        if ($this->hasRoleInPart($role)) {
            $this->addRole($role);
        }
    }

    public function addMember()
    {
        $role = Role::where('name', 'faculty')->first();

        if (!$this->hasRoleInPart($role)) {
            $this->addRole($role);
        }
    }

    public function hasRoleInPart($role)
    {
        $role_instance = DB::table('role_user')
            ->where('role_id', $role->id)
            ->where('user_id', $this->member->id)
            ->where('enterprise_part_id', $this->part->id)
            ->first();


        return !is_null($role_instance);
    }

    public function addRole($role)
    {
        $insert = DB::table('role_user')->insert([[
            'role_id' => $role->id,
            'user_id' => $this->member->id,
            'enterprise_part_id' => $this->part->id
        ]]);
    }

    public function removeRole($role)
    {
        $role_instance = DB::table('role_user')
            ->where('role_id', $role->id)
            ->where('user_id', $this->member->id)
            ->where('enterprise_part_id', $this->part->id)
            ->first();

        $role_instance->delete();
    }
}