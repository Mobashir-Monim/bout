<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Excel;
use App\Imports\SeedImport;
use App\Models\Course;
use App\Models\OfferedCourse;
use App\Models\User;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = Excel::toArray(new SeedImport, str_replace('storage', 'public\files', storage_path('courses.xlsx')))[0];

        foreach ($rows as $key => $row) {
            $course = Course::create([
                'code' => $row['code'],
                'title' => trim(explode('(', $row['title'])[0]),
                'provider' => $row['provider'],
            ]);

            if (is_null(User::where('email', $row['email'])->first())) {
                User::create([
                    'name' => $row['coordinator'],
                    'email' => $row['email'],
                    'password' => bcrypt(''),
                ]);
            }

            $offered = OfferedCourse::create([
                'course_id' => $course->id,
                'run_id' => $row['run_id'],
                'coordinator' => $row['coordinator'],
                'email' => $row['email'],
                'initials' => $row['initials'],
                'bux_code' => $row['bux_code'],
            ]);
        }
    }
}
