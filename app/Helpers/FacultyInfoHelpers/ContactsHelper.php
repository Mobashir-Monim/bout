<?php

namespace App\Helpers\FacultyInfoHelpers;

use App\Helpers\Helper;
use App\Helpers\RoleHelpers\FindInstances;
use App\Helpers\RoleHelpers\CompileInstances;
use App\Models\Role;
use App\Models\EnterprisePart;
use DB;

class ContactsHelper extends Helper
{
    public function compileDCOs()
    {
        $compiled = [];

        foreach (EnterprisePart::where('is_academic_part', true)->get() as $part) {
            $name = "$part->name " . (is_null($part->acronym) ? "" : "($part->acronym)");
            $roles = Role::where('name', 'like', 'dco%')->get();
            
            foreach ($roles as $role) {
                $compiled[$name][$role->display_name] = (new CompileInstances(
                    (new FindInstances(['role' => $role, 'part' => $part]))
                        ->search()))->compile();
            }
        }

        return $compiled;
    }

    public function compileProgramCoordinators()
    {
        $compiled = [];

        foreach (EnterprisePart::where('is_academic_part', true)->get() as $part) {
            $name = "$part->name " . (is_null($part->acronym) ? "" : "($part->acronym)");
            $roles = Role::whereIn('id', DB::table('role_user')
                        ->whereIn('role_id',
                            Role::where('name', 'like', 'program-coordinator%')->get()->pluck('id')->toArray())
                        ->where('enterprise_part_id', $part->id)->get()->pluck('role_id')->toArray())->get();

            foreach ($roles as $role) {
                $compiled[$name][$role->display_name] = (new CompileInstances(
                    (new FindInstances(['role' => $role, 'part' => $part]))
                        ->search()))->compile();
            }
        }

        return $compiled;
    }
}