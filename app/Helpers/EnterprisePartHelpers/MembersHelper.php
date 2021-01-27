<?php

namespace App\Helpers\EnterprisePartHelpers;

use App\Helpers\Helper;
use App\Models\User;
use App\Models\Role;

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
        $this->addMember();
        $this->member->roles()->attach(Role::where('name', 'dco')->first()->id);
    }

    public function removeMember()
    {
        $this->member->memberOf()->detach($this->part->id);
    }

    public function addMember()
    {
        if (!in_array($this->part->id, $this->member->memberOf->pluck('id')->toArray())) {
            $this->member->memberOf()->attach($this->part->id);
        }
    }
}