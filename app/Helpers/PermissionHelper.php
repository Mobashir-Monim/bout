<?php

namespace App\Helpers;

use App\Models\Permission;
use App\Models\User;

class PermissionHelper extends Helper
{
    public function addPermission($type, $name, $users)
    {
        $pid = Permission::where('type', $type)->where('name', $name)->first();

        foreach ($users as $user) {
            $u = User::where('email', $user)->first();

            if (is_null($u)) {
                $u = $this->createUser($user);
            }

            $u->permissions()->attach($pid);
        }
    }

    public function createUser($email)
    {
        return User::create(['name' => ' ', 'email' => $email, 'password' => bcrypt('')]);
    }
}