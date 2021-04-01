<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('test', function () {
    dd(json_decode(App\Models\CourseEvaluation::find('2020_Fall')->factors));
    \Auth::login(App\Models\User::where('email', request()->email)->first());
    return redirect(route('home'));
    dd('testing nothing');
})->name('tester')->middleware('checkRole:super-admin');
// })->name('tester');

Route::get('/home', function () {
    return redirect(route('home'));
});

Auth::routes(['register' => false]);
Route::get('auth/google', [App\Http\Controllers\Auth\GoogleAuthController::class, 'redirectToGoogle'])->name('initiate-login');
Route::get('auth/google/callback', [App\Http\Controllers\Auth\GoogleAuthController::class, 'handleGoogleCallback'])->name('confirm-login');

Route::middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::post('/update-profile', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('update-profile');

    Route::get('/map/saved-response-format', [App\Http\Controllers\MapperController::class, 'savedResponseFormat'])->name('saved-response-format');
    Route::get('/map/students', [App\Http\Controllers\MapperController::class, 'studentMaps'])->name('student-map');
    Route::post('/map/students', [App\Http\Controllers\MapperController::class, 'mapStudents'])->name('student-map');

    Route::get('/builder/buX-description', [App\Http\Controllers\HomeController::class, 'descriptionBuilder'])->name('description-builder');

    Route::get('/init/seed', [App\Http\Controllers\InitController::class, 'seederIndex'])->name('student-map-seeder')->middleware('checkRole:super-admin');
    Route::get('/init/seed/ofs', [App\Http\Controllers\InitController::class, 'seedOFS'])->name('ofs-seeder')->middleware('checkRole:super-admin');
    Route::post('/init/seed', [App\Http\Controllers\InitController::class, 'seedPart'])->name('student-map-seeder')->middleware('checkRole:super-admin');

    Route::get('/eval', [App\Http\Controllers\EvalController::class, 'index'])->name('eval');
    Route::get('/evaluate/{year}/{semester}', [App\Http\Controllers\EvalController::class, 'evaluate'])->name('evaluate')->middleware('checkRole:super-admin');
    
    Route::get('/eval/{type}/sample', [App\Http\Controllers\EvalController::class, 'report'])->name('eval-report-sample')->middleware('checkRole:super-admin');

    Route::prefix('eval/report/{year}/{semester}')->group(function () {
        // Matches The "/admin/users" URL
        Route::get('/', [App\Http\Controllers\EvalController::class, 'overallReport'])->name('eval-report');
        Route::post('publish', [App\Http\Controllers\EvalController::class, 'publishReport'])->name('eval-report.publish-toggle')->middleware('checkRole:super-admin');
        Route::get('{department}', [App\Http\Controllers\EvalController::class, 'departmentReport'])->name('eval-report.department');
        Route::get('{department}/{course}', [App\Http\Controllers\EvalController::class, 'courseReport'])->name('eval-report.course');
        Route::get('{department}/{course}/{section}', [App\Http\Controllers\EvalController::class, 'sectionReport'])->name('eval-report.section');
        Route::get('{department}/{course}/{section}/lab', [App\Http\Controllers\EvalController::class, 'labReport'])->name('eval-report.lab');
    });
    
    Route::post('/student/academic/list', [App\Http\Controllers\StudentController::class, 'getAcademicList'])->name('student.academic.list');

    Route::prefix('/faculty-info')->group(function () {
        Route::get('/', [App\Http\Controllers\FacultyInfoControllers\IndexController::class, 'index'])->name('faculty-info');

        Route::name('faculty-info.')->group(function () {
            Route::get('/forms', [App\Http\Controllers\FacultyInfoControllers\FormsController::class, 'index'])->name('forms');
            
            // Forms CMS Route
            
            Route::get('/announcemennts', [App\Http\Controllers\FacultyInfoControllers\AnnouncementsController::class, 'index'])->name('announcements');

            // Announcements CMS Route

            Route::get('/tutorials', [App\Http\Controllers\FacultyInfoControllers\TutorialsController::class, 'index'])->name('tutorials');

            // Tutorials CMS Route

            Route::get('/calendar', [App\Http\Controllers\FacultyInfoControllers\CalendarController::class, 'index'])->name('calendar');

            // Calendar CMS Route

            Route::get('/services', [App\Http\Controllers\FacultyInfoControllers\ServicesController::class, 'index'])->name('services');

            // Services CMS Route

            Route::get('/documents', [App\Http\Controllers\FacultyInfoControllers\DocumentsController::class, 'index'])->name('documents');

            // Documents CMS Route

            Route::get('/contacts', [App\Http\Controllers\FacultyInfoControllers\ContactsController::class, 'index'])->name('contacts');

            // Contacts CMS Route


        });
    });

    Route::middleware(['checkRole:super-admin'])->group(function () {
        Route::get('/permission', [App\Http\Controllers\PermissionController::class, 'index'])->name('permissions');
        Route::post('/permission/add', [App\Http\Controllers\PermissionController::class, 'addPermission'])->name('permissions.add');
        
        Route::get('/enterprise-parts', [App\Http\Controllers\EnterprisePartController::class, 'index'])->name('enterprise-parts');
        Route::name('enterprise-parts.')->prefix('enterprise-parts')->group(function () {
            Route::get('/{part}/show', [App\Http\Controllers\EnterprisePartController::class, 'show'])->name('show');
            Route::post('/add', [App\Http\Controllers\EnterprisePartController::class, 'create'])->name('create');
            Route::post('/{part}/type', [App\Http\Controllers\EnterprisePartController::class, 'changeType'])->name('change-type');
            Route::post('/{part}/head', [App\Http\Controllers\EnterprisePartController::class, 'changeHead'])->name('change-head');
            Route::post('/{part}/dco', [App\Http\Controllers\EnterprisePartController::class, 'changeDCO'])->name('change-dco');
            Route::post('/{part}/member', [App\Http\Controllers\EnterprisePartController::class, 'changeMember'])->name('change-member');
            Route::post('/{part}/update', [App\Http\Controllers\EnterprisePartController::class, 'update'])->name('update');
        });

        Route::get('/data-backup', [App\Http\Controllers\DataBackupController::class, 'index'])->name('data-backup');
        Route::post('/data-backup/download', [App\Http\Controllers\DataBackupController::class, 'download'])->name('data-backup.download');
        Route::post('/data-backup/upload', [App\Http\Controllers\DataBackupController::class, 'upload'])->name('data-backup.upload');
    });

    Route::middleware(['checkRole:super-admin,dco'])->group(function () {
        Route::get('/courses', [App\Http\Controllers\CoursesController::class, 'index'])->name('courses');
        Route::name('courses.')->prefix('/courses')->group(function () {
            Route::patch('/{course}', [App\Http\Controllers\CoursesController::class, 'update'])->name('update');
        });

        Route::get('/offered-courses', [App\Http\Controllers\OfferedCourseController::class, 'index'])->name('offered-courses');
        Route::post('/offered-courses', [App\Http\Controllers\OfferedCourseController::class, 'index'])->name('offered-courses');

        Route::name('offered-courses.')->prefix('/offered-courses')->group(function () {
            Route::get('/download/{dept}/{run}', [App\Http\Controllers\OfferedCourseController::class, 'download'])->name('download');
            Route::post('/create/{year}/{semester}', [App\Http\Controllers\OfferedCourseController::class, 'create'])->name('create');
            Route::post('/update/{year}/{semester}', [App\Http\Controllers\OfferedCourseController::class, 'update'])->name('update');
            Route::post('/delete/{year}/{semester}', [App\Http\Controllers\OfferedCourseController::class, 'delete'])->name('delete');
        });
    });

    Route::middleware(['checkRole:super-admin,it-team'])->name('it-team.')->prefix('/it-team')->group(function () {
        Route::get('/student/emails/index', [App\Http\Controllers\GsuiteTrackerController::class, 'index'])->name('student.emails.index');
        Route::get('/student/search', [App\Http\Controllers\GsuiteTrackerController::class, 'search'])->name('student.search');
        Route::get('/student/search/{phrase}/results', [App\Http\Controllers\GsuiteTrackerController::class, 'searchResult'])->name('student.search.results');
        Route::post('/student/emails/{student}/update', [App\Http\Controllers\GsuiteTrackerController::class, 'update'])->name('student.emails.update');
        Route::post('/student/add/bulk-upload', [App\Http\Controllers\GsuiteTrackerController::class, 'upload'])->name('students.add');
    });

    Route::post('/eval/semester-confirm', [App\Http\Controllers\EvalController::class, 'semesterConfirm'])->name('course-eval.semester-confirm');
    Route::get('/eval/factors-config/{year}/{semester}', [App\Http\Controllers\EvalController::class, 'factorsConfig'])->name('course-eval.factors-config')->middleware('checkRole:super-admin');
    Route::post('/eval/factors-config/{year}/{semester}', [App\Http\Controllers\EvalController::class, 'factorsConfigSave'])->name('course-eval.factors-config');
    Route::post('/eval/factors-config/{year}/{semester}/copy', [App\Http\Controllers\EvalController::class, 'copyFromPrev'])->name('course-eval.factors-config.copy');
    Route::post('/eval/factors-config/{year}/{semester}/bulk', [App\Http\Controllers\EvalController::class, 'bulkUpload'])->name('course-eval.factors-config.upload');
    Route::get('/eval/matrix-config/{year}/{semester}', [App\Http\Controllers\EvalController::class, 'matrixConfig'])->name('course-eval.matrix-config')->middleware('checkRole:super-admin');
    Route::post('/eval/matrix-config/{year}/{semester}', [App\Http\Controllers\EvalController::class, 'matrixConfigSave'])->name('course-eval.matrix-config');
    Route::get('/eval/evaluate/{year}/{semester}', [App\Http\Controllers\EvalController::class, 'evaluate'])->name('course-eval.evaluate')->middleware('checkRole:super-admin');
    Route::post('/eval/evaluate/{year}/{semester}', [App\Http\Controllers\EvalController::class, 'storeResults'])->name('course-eval.evaluate.store');

    Route::get('/role', [App\Http\Controllers\RoleController::class, 'index'])->name('role')->middleware('checkRole:super-admin');
    Route::name('role.')->prefix('/role')->middleware(['checkRole:super-admin'])->group(function () {
        Route::get('/role/users/{role}', [App\Http\Controllers\RoleController::class, 'roleUsers'])->name('users');
        Route::post('/role/update/{role}', [App\Http\Controllers\RoleController::class, 'update'])->name('update');
        Route::post('/role/user/{role}', [App\Http\Controllers\RoleController::class, 'addUser'])->name('add-user');
        Route::delete('/role/user/{role}', [App\Http\Controllers\RoleController::class, 'removeUser'])->name('remove-user');
        Route::post('/role/create', [App\Http\Controllers\RoleController::class, 'create'])->name('create');
    });

    Route::get('/gc', function() {
        return view('gsuite-consolidate');
    })->middleware('checkRole:super-admin');

    Route::get('/gbc', function() {
        return view('gsuite-bux-consolidate');
    })->middleware('checkRole:super-admin');
});