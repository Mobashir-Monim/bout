<?php

namespace App\Helpers\RoleHelpers;

use App\Helpers\Helper;
use App\Models\Role;
use App\Models\User;
use App\Models\EnterprisePart;

class CompileInstances extends Helper
{
    protected $instances;

    public function __construct($instances)
    {
        $this->instances = $instances;
    }

    public function compile()
    {
        $compiled = [];

        foreach ($this->instances as $instance) {
            $compiled[] = [
                'id' => $instance->id,
                'role' => $this->getRoleDetails($instance),
                'user' => $this->getUserDetails($instance),
                'part' => $this->getPartDetails($instance),
            ];
        }

        return $compiled;
    }

    public function getRoleDetails($instance)
    {
        $role = Role::find($instance->role_id);

        return [
            'id' => $role->id,
            'name' => $role->name,
            'display_name' => $role->display_name,
            'is_head' => $role->is_head,
        ];
    }

    public function getUserDetails($instance)
    {
        $user = User::find($instance->user_id);

        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'show_phone' => $user->show_phone,
        ];
    }

    public function getPartDetails($instance)
    {
        $part = EnterprisePart::find($instance->enterprise_part_id);

        if (is_null($part)) {
            return [
                'id' => null,
                'name' => null,
                'acronym' => null,
                'is_academic_part' => null
            ];
        }

        return [
            'id' => $part->id,
            'name' => $part->name,
            'acronym' => $part->acronym,
            'is_academic_part' => $part->is_academic_part,
        ];
    }
}