<?php

namespace App\Helpers;

use App\Models\Permission;
use App\Models\User;

class PermissionHelper extends Helper
{
    public function addPermission($type, $name, $users)
    {
        $pid = Permission::where('type', $type)->where('name', $name)->first();
        $users = User::whereIn('email', $users)->get();

        foreach ($users as $user) {
            $user->permissions()->attach($pid);
        }
    }
}