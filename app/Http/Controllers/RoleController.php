<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RoleUsersRequest;
use App\Helpers\RoleHelpers\FindInstances;
use App\Helpers\RoleHelpers\CompileInstances;
use App\Models\Role;
use App\Models\User;
use DB;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('display_name')->get();

        return view('role.index', ['roles' => $roles]);
    }

    public function roleUsers(Role $role)
    {   
        $instances = (new FindInstances(['role' => $role]))->search();
        $compiled = (new CompileInstances($instances))->compile();

        return response()->json([
            'success' => true,
            'message' => 'Succesfully retrieved all users',
            'instances' => $compiled
        ]);
    }

    public function update(Role $role, Request $request)
    {
        $role->name = $request->name;
        $role->display_name = $request->display_name;
        $role->limit = $request->limit;
        $role->save();

        return response()->json([
            'success' => true,
            'message' => 'Successfully updated role'
        ]);
    }

    public function addUser(Role $role, Request $request)
    {
        $user = User::where('email', $request->email)->first();
        
        if (!is_null($user)) {
            DB::table('role_user')->insert([[
                'role_id' => $role->id,
                'user_id' => $user->id,
                'enterprise_part_id' => $request->department
            ]]);

            return response()->json([
                'success' => true,
                'message' => 'Role added to user',
                'name' => $user->name,
                'email' => $user->email,
                'count' => count($role->users)
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'User with this email address not found'
        ]);
    }

    public function removeUser(Role $role, Request $request)
    {
        DB::table('role_user')->where('id', $request->instance)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Successfully removed user'
        ]);
    }
}
