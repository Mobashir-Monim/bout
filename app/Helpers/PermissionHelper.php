<?php

namespace App\Helpers;

use App\Models\Permission;
use App\Models\User;
use DB;

class PermissionHelper extends Helper
{
    public function addPermission($type, $name, $users)
    {
        $permission = Permission::where('type', $type)->where('name', $name)->first();

        foreach ($users as $user) {
            $u = User::where('email', $user)->first();

            if (is_null($u)) {
                $u = $this->createUser($user);
            }

            $this->attachPermission($permission, $u, request()->eps);
        }
    }

    public function createUser($email)
    {
        return User::create(['name' => ' ', 'email' => $email, 'password' => bcrypt('')]);
    }

    public function attachPermission($permission, $user, $depts)
    {
        $instance = $this->findInstance($permission, $user);
        $depts = is_null($depts) ? null : implode(',', $depts);

        DB::table('permission_user')
            ->where('id', $instance->id)
            ->update(['enterprise_parts' => $depts]);
    }

    public function findInstance($permission, $user)
    {
        $instance = DB::table('permission_user')
                    ->where('permission_id', $permission->id)
                    ->where('user_id', $user->id)
                    ->first();

        if (is_null($instance)) {
            DB::table('permission_user')->insert([
                'permission_id' => $permission->id,
                'user_id' => $user->id
            ]);

            $instance = DB::table('permission_user')
                    ->where('permission_id', $permission->id)
                    ->where('user_id', $user->id)
                    ->first();
        }

        return $instance;
    }
}