<?php

namespace App\Helpers\DataBackupHelpers;

use App\Helpers\Helper;
use \DB;

class BackupHelper extends Helper
{
    public $tables = [
        ['type' => 'application','model' => 'Config', 'name' => 'configs'],
        ['type' => 'application','model' => 'CourseEvaluationMatrix', 'name' => 'course_evaluation_matrices'],
        ['type' => 'application','model' => 'CourseEvaluationResult', 'name' => 'course_evaluation_results'],
        ['type' => 'application','model' => 'CourseEvaluation', 'name' => 'course_evaluations'],
        ['type' => 'application','model' => 'Course', 'name' => 'courses'],
        ['type' => 'application','model' => 'EnterprisePartRelationship', 'name' => 'enterprise_part_relationships'],
        ['type' => 'application','model' => 'EnterprisePart', 'name' => 'enterprise_parts'],
        ['type' => 'application','model' => 'OfferedCourseSection', 'name' => 'offered_course_sections'],
        ['type' => 'application','model' => 'OfferedCourse', 'name' => 'offered_courses'],
        ['type' => 'application','model' => 'Permission', 'name' => 'permissions'],
        ['type' => 'application','model' => 'Role', 'name' => 'roles'],
        ['type' => 'application','model' => 'Run', 'name' => 'runs'],
        ['type' => 'application','model' => 'StudentEnrollment', 'name' => 'student_enrollments'],
        ['type' => 'application','model' => 'StudentMap', 'name' => 'student_maps'],
        ['type' => 'application','model' => 'Student', 'name' => 'students'],
        ['type' => 'application','model' => 'User', 'name' => 'users'],
        ['type' => 'application','model' => null, 'name' => 'oauth_access_tokens'],
        ['type' => 'application','model' => null, 'name' => 'oauth_auth_codes'],
        ['type' => 'application','model' => null, 'name' => 'oauth_clients'],
        ['type' => 'application','model' => null, 'name' => 'oauth_personal_access_clients'],
        ['type' => 'application','model' => null, 'name' => 'oauth_refresh_tokens'],
        ['type' => 'application','model' => null, 'name' => 'permission_role'],
        ['type' => 'application','model' => null, 'name' => 'permission_user'],
        ['type' => 'application','model' => null, 'name' => 'role_user'],
        // ['type' => 'system','model' => null, 'name' => 'failed_jobs'],
        // ['type' => 'system','model' => null, 'name' => 'migrations'],
        // ['type' => 'system','model' => null, 'name' => 'password_resets'],
    ];

    public function validateTable()
    {
        foreach ($this->tables as $table) {
            if ($table['name'] == $this->table) {
                return true;
            }
        }

        return false;
    }

    public function getTablesWithDescription()
    {
        $tables = [];

        foreach ($this->tables as $name => $table) {
            $tables[$name] = [];
            $tables[$name]['description'] = DB::select('describe ' . $table['name']);

            foreach ($table as $key => $value) {
                $tables[$name][$key] = $value;
            }
        }

        return $tables;
    }
}