<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RoleUsersRequest;
use App\Models\Role;
use App\Models\User;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('display_name')->get();

        return view('role.index', ['roles' => $roles]);
    }

    public function roleUsers(Role $role)
    {   
        if (is_null($role)) {
            return response()->json([
                'succes' => false,
                'message' => 'Role not found'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Succesfully retrieved all users',
            'data' => [
                'users' => $role->users
            ]
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
            $role->users()->attach($user->id);

            return response()->json([
                'success' => true,
                'message' => 'Role added to user'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'User with this email address not found'
        ]);
    }
}
