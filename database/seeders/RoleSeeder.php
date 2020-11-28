<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['name' => 'super-admin', 'display_name' => 'Super Admin', 'limit' => 1],
            ['name' => 'admin', 'display_name' => 'Admin', 'limit' => 10],
            ['name' => 'trustee-member', 'display_name' => 'Trustee Member', 'limit' => 15],
            ['name' => 'vc', 'display_name' => 'Vice Chancellor', 'limit' => 1],
            ['name' => 'dean', 'display_name' => 'Dean', 'limit' => 7],
            ['name' => 'chair', 'display_name' => 'Chair', 'limit' => 10],
            ['name' => 'dco', 'display_name' => 'Department Coordinator', 'limit' => 15],
            ['name' => 'online-learning-chair', 'display_name' => 'Online Learning Chair', 'limit' => 1],
            ['name' => 'bux-lead', 'display_name' => 'buX Lead', 'limit' => 1],
            ['name' => 'bux-support', 'display_name' => 'buX Support', 'limit' => 10],
            ['name' => 'monitoring-team-lead', 'display_name' => 'Monitoring Team Lead', 'limit' => 1],
            ['name' => 'monitoring-team', 'display_name' => 'Monitoring Team', 'limit' => 10],
            ['name' => 'academic-complaints-lead', 'display_name' => 'Academic Complaints Lead', 'limit' => 1],
            ['name' => 'academic-complaints', 'display_name' => 'Academic Complaints', 'limit' => 10],
            ['name' => 'faculty', 'display_name' => 'Faculty', 'limit' => 600],
            ['name' => 'it-head', 'display_name' => 'IT Head', 'limit' => 1],
            ['name' => 'it-team', 'display_name' => 'IT Team', 'limit' => 15],
        ];

        foreach ($roles as $key => $role) {
            Role::create($role);
        }
    }
}
