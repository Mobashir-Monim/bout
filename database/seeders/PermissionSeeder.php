<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\User;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = ['skazi@bracu.ac.bd', 'mahboob.rahman@bracu.ac.bd', 'mabdullah@bracu.ac.bd'];
        $permissions = [
            ['type' => 'course-evaluation', 'name' => 'filter', 'title' => 'Course Evaluation Filtering', 'description' => 'Allows filtering view of course evaluations'],
            ['type' => 'course-evaluation', 'name' => 'dept-report', 'title' => 'Course Evaluation Department Report', 'description' => 'Allows viewing department report of course evaluations'],
            ['type' => 'course-evaluation', 'name' => 'course-report', 'title' => 'Course Overall Evaluation Report', 'description' => 'Allows viewing overall course report of course evaluations'],
            ['type' => 'course-evaluation', 'name' => 'section-report', 'title' => 'Course Section Evaluation Report', 'description' => 'Allows viewing course section report of course evaluations'],
            ['type' => 'course-evaluation', 'name' => 'lab-report', 'title' => 'Course Lab Evaluation Report', 'description' => 'Allows viewing course lab report of course evaluations'],
        ];

        foreach ($permissions as $permission) {
            $permission = Permission::create($permission);

            foreach ($users as $user) {
                $user = User::where('email', $user)->first();
                $user->permissions()->attach($permission->id);
            }
        }
    }
}
