<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
use App\Helpers\PermissionHelper;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::orderBy('type')->get();

        return view('permission.index', ['permissions' => $permissions]);
    }

    public function store(Request $request)
    {
        Permission::create([
            'type' => $request->type,
            'name' => $request->name,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('permissions');
    }

    public function addPermission(Request $request)
    {
        $helper = new PermissionHelper;
        $users = explode(',', str_replace(' ', '', $request->users));
        $helper->addPermission($request->type, $request->name, $users);

        $this->flashMessage('success', 'Permission added to ' . implode(', ', $users));

        return redirect(route('permissions'));
    }
}
