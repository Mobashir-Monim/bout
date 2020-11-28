<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RoleUsersRequest;
use App\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('display_name')->get();

        return view('role.index', ['roles' => $roles]);
    }

    public function roleUsers(Role $role)
    {
        dd($role);
        $role = Role::find($role);
        
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

    public function saveRole(Role $role)
    {
        
    }
}
