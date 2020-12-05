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
    \Auth::login(App\Models\User::find('e9abd39b-7d8e-4f3a-9d2f-4df416583a87'));
    return redirect(route('home'));
    dd(App\Models\CourseEvaluation::find("2020_Summer")->results);
    dd(json_decode(base64_decode('eyJuYW1lIjoiREVQQVJUTUVOVCBPRiBBUkNISVRFQ1RVUkUiLCJjYXRzIjp7ImxxIjoxMS45MywiY3EiOjMwLjk3LCJjYSI6MjYuOTgsImFlIjoxOC4xLCJseCI6MTguMzUsInNwIjozLjcyLCJsZSI6MjIuNjEsInRhIjo2LjYyLCJjciI6OC42LCJsciI6bnVsbCwiZWkiOjE3LjE2LCJpaSI6Ni4yNiwiciI6MH0sInN0dWRlbnRzIjoxNjQyLCJyZXNwb25kZW50cyI6Mzk0LCJvdmVyYWxsIjp7InBlcmNlbnRpbGVzIjp7ImxxIjo5MCwiY3EiOjkwLCJjYSI6ODAsImFlIjo4MCwibHgiOjEwMCwic3AiOjEwLCJsZSI6OTAsInRhIjo1MCwiY3IiOjEwMCwibHIiOjAsImVpIjo3MCwiaWkiOjMwLCJyIjoxMH0sImRlcHRDb3Vyc2VIaWdoZXN0cyI6eyJscSI6MTQuMjgsImNxIjozNy42LCJjYSI6MzEuODUsImFlIjoyMi42NywibHgiOjIzLjc1LCJzcCI6Ny4xNywibGUiOjI2LjYzLCJ0YSI6OC44MywiY3IiOjEwLCJsciI6bnVsbCwiZWkiOjIxLjE0LCJpaSI6MTQsInIiOjB9LCJ1bmlDb3Vyc2VIaWdoZXN0cyI6eyJscSI6MTcsImNxIjo0MywiY2EiOjM1LjU3LCJhZSI6MjIuNjcsImx4IjoyNC4yLCJzcCI6MTEuNSwibGUiOjI5LjY3LCJ0YSI6MTIsImNyIjoxMCwibHIiOm51bGwsImVpIjoyMy42LCJpaSI6MjQuNTksInIiOjB9LCJ1bmlIaWdoZXN0cyI6eyJscSI6MTIuMjQsImNxIjozMS4wOSwiY2EiOjI4LjcxLCJhZSI6MTkuMTIsImx4IjoxOC4zNSwic3AiOjYuMjgsImxlIjoyMi45MSwidGEiOjcuODYsImNyIjo4LjYsImxyIjpudWxsLCJlaSI6MTguNSwiaWkiOjEyLCJyIjowfSwiY291cnNlQ291bnQiOjM1LCJzZWN0aW9uQ291bnQiOjE0fSwibG93ZXN0Ijp7ImxxIjoiQVJDNDMxLCBBUkM1MjIsIEVDTzEwNCwgQVJDMzk0LCBBUkMxMjMiLCJjcSI6IkFSQzMzMSwgQVJDNDMxLCBFQ08xMDQsIEFSQzM5NCwgQVJDMTIzIiwiY2EiOiJBUkMzMzEsIEFSQzQxMywgQVJDNDMxLCBFQ08xMDQsIEFSQzM5NCwgQVJDNDMyIiwiYWUiOiJBUkM0OTQsIEFSQzQzMSwgQ0VFMjEyLCBFQ08xMDQsIEFSQzM5NCIsImx4IjoiQVJDNDkxLCBBUkM1MjIsIEVDTzEwNCwgQVJDMzk0LCBBUkM0MzIiLCJzcCI6IkFSQzQ1MiwgQVJDNDkzLCBQSEk1MjEsIEFSQzM5NCwgQVJDMjQyIiwibGUiOiJBUkM0OTEsIEFSQzQzMSwgRUNPMTA0LCBBUkMzOTQsIEFSQzMyNyIsInRhIjoiQU5UMTAzLCBBUkMzMzEsIEFSQzQzMSwgRUNPMTA0LCBBUkMzNDMiLCJjciI6IkFSQzI1MSwgRU5WMTAxLCBFQ08xMDQsIEFSQzM5NCwgUEhZMTAyIiwibHIiOiIiLCJlaSI6IkFSQzQ5MSwgQVJDNDMxLCBFQ08xMDQsIEFSQzM5NCwgQVJDMTIzIiwiaWkiOiJBTlQxMDMsIEFSQzI0MSwgTUVFMzQ0LCBNQVQxMDQsIEFSQzM5MyJ9LCJoaWdoZXN0Ijp7ImxxIjoiQVJDMjI0LCBBUkMyNDEsIEFSQzQ1MiwgQVJDNDkzLCBQSEk1MjEiLCJjcSI6IkFSQzI1MiwgQVJDMjI0LCBBUkMyNDEsIFBIWTEwMiwgQVJDMjQyIiwiY2EiOiJBUkMyNTIsIEFSQzIyNCwgQVJDMjQxLCBNRUUzNDQsIEFSQzEyMSIsImFlIjoiQVJDMjUxLCBBUkMyNDEsIEFSQzQxMywgTUVFMzQ0LCBNQVQxMDQsIFBIWTEwMiIsImx4IjoiQVJDMjQxLCBBUkM0MTMsIE1FRTM0NCwgQVJDNDkzLCBQSEk1MjEiLCJzcCI6IkFSQzI1MSwgQVJDNDEzLCBNQVQxMDQsIEVOVjEwMSwgUEhZMTAyIiwibGUiOiJBUkM0MTMsIEFSQzQ5MywgUEhJNTIxLCBBUkMxMjEsIEFSQzI0MiIsInRhIjoiTUVFMzQ0LCBBUkM0OTMsIFBIWTEwMiwgQVJDMTIyLCBDRUU0MTIiLCJjciI6IkFSQzQ5MywgUEhJNTIxLCBBUkMxMjEsIEFSQzEyMiwgQVJDMjQyIiwibHIiOiIiLCJlaSI6IkFSQzI0MSwgQVJDNDEzLCBNRUUzNDQsIE1BVDEwNCwgUEhZMTAyIiwiaWkiOiJBUkM0OTEsIEFSQzQzMSwgRUNPMTA0LCBBUkMzOTQsIEFSQzMyNyJ9fQ==')), 'hi');
    dd(json_decode(base64_decode("eyJuYW1lIjoiREVQQVJUTUVOVCBPRiBBUkNISVRFQ1RVUkUiLCJjYXRzIjp7ImxxIjoxMS45MywiY3EiOjMwLjk3LCJjYSI6MjYuOTgsImFlIjoxOC4xLCJseCI6MTguMzUsInNwIjozLjcyLCJsZSI6MjIuNjEsInRhIjo2LjYyLCJjciI6OC42LCJsciI6bnVsbCwiZWkiOjE3LjE2LCJpaSI6Ni4yNiwiciI6MH0sInN0dWRlbnRzIjoxNjQyLCJyZXNwb25kZW50cyI6Mzk0LCJvdmVyYWxsIjp7InBlcmNlbnRpbGVzIjp7ImxxIjo5MCwiY3EiOjkwLCJjYSI6ODAsImFlIjo4MCwibHgiOjEwMCwic3AiOjEwLCJsZSI6OTAsInRhIjo1MCwiY3IiOjEwMCwibHIiOjAsImVpIjo3MCwiaWkiOjMwLCJyIjoxMH0sImRlcHRDb3Vyc2VIaWdoZXN0cyI6eyJscSI6MTQuMjgsImNxIjozNy42LCJjYSI6MzEuODUsImFlIjoyMi42NywibHgiOjIzLjc1LCJzcCI6Ny4xNywibGUiOjI2LjYzLCJ0YSI6OC44MywiY3IiOjEwLCJsciI6bnVsbCwiZWkiOjIxLjE0LCJpaSI6MTQsInIiOjB9LCJ1bmlDb3Vyc2VIaWdoZXN0cyI6eyJscSI6MTcsImNxIjo0MywiY2EiOjM1LjU3LCJhZSI6MjIuNjcsImx4IjoyNC4yLCJzcCI6MTEuNSwibGUiOjI5LjY3LCJ0YSI6MTIsImNyIjoxMCwibHIiOm51bGwsImVpIjoyMy42LCJpaSI6MjQuNTksInIiOjB9LCJ1bmlIaWdoZXN0cyI6eyJscSI6MTIuMjQsImNxIjozMS4wOSwiY2EiOjI4LjcxLCJhZSI6MTkuMTIsImx4IjoxOC4zNSwic3AiOjYuMjgsImxlIjoyMi45MSwidGEiOjcuODYsImNyIjo4LjYsImxyIjpudWxsLCJlaSI6MTguNSwiaWkiOjEyLCJyIjowfSwiY291cnNlQ291bnQiOjM1LCJzZWN0aW9uQ291bnQiOjE0fSwibG93ZXN0Ijp7ImxxIjoiQVJDNDMxLCBBUkM1MjIsIEVDTzEwNCwgQVJDMzk0LCBBUkMxMjMiLCJjcSI6IkFSQzMzMSwgQVJDNDMxLCBFQ08xMDQsIEFSQzM5NCwgQVJDMTIzIiwiY2EiOiJBUkMzMzEsIEFSQzQxMywgQVJDNDMxLCBFQ08xMDQsIEFSQzM5NCwgQVJDNDMyIiwiYWUiOiJBUkM0OTQsIEFSQzQzMSwgQ0VFMjEyLCBFQ08xMDQsIEFSQzM5NCIsImx4IjoiQVJDNDkxLCBBUkM1MjIsIEVDTzEwNCwgQVJDMzk0LCBBUkM0MzIiLCJzcCI6IkFSQzQ1MiwgQVJDNDkzLCBQSEk1MjEsIEFSQzM5NCwgQVJDMjQyIiwibGUiOiJBUkM0OTEsIEFSQzQzMSwgRUNPMTA0LCBBUkMzOTQsIEFSQzMyNyIsInRhIjoiQU5UMTAzLCBBUkMzMzEsIEFSQzQzMSwgRUNPMTA0LCBBUkMzNDMiLCJjciI6IkFSQzI1MSwgRU5WMTAxLCBFQ08xMDQsIEFSQzM5NCwgUEhZMTAyIiwibHIiOiIiLCJlaSI6IkFSQzQ5MSwgQVJDNDMxLCBFQ08xMDQsIEFSQzM5NCwgQVJDMTIzIiwiaWkiOiJBTlQxMDMsIEFSQzI0MSwgTUVFMzQ0LCBNQVQxMDQsIEFSQzM5MyJ9LCJoaWdoZXN0Ijp7ImxxIjoiQVJDMjI0LCBBUkMyNDEsIEFSQzQ1MiwgQVJDNDkzLCBQSEk1MjEiLCJjcSI6IkFSQzI1MiwgQVJDMjI0LCBBUkMyNDEsIFBIWTEwMiwgQVJDMjQyIiwiY2EiOiJBUkMyNTIsIEFSQzIyNCwgQVJDMjQxLCBNRUUzNDQsIEFSQzEyMSIsImFlIjoiQVJDMjUxLCBBUkMyNDEsIEFSQzQxMywgTUVFMzQ0LCBNQVQxMDQsIFBIWTEwMiIsImx4IjoiQVJDMjQxLCBBUkM0MTMsIE1FRTM0NCwgQVJDNDkzLCBQSEk1MjEiLCJzcCI6IkFSQzI1MSwgQVJDNDEzLCBNQVQxMDQsIEVOVjEwMSwgUEhZMTAyIiwibGUiOiJBUkM0MTMsIEFSQzQ5MywgUEhJNTIxLCBBUkMxMjEsIEFSQzI0MiIsInRhIjoiTUVFMzQ0LCBBUkM0OTMsIFBIWTEwMiwgQVJDMTIyLCBDRUU0MTIiLCJjciI6IkFSQzQ5MywgUEhJNTIxLCBBUkMxMjEsIEFSQzEyMiwgQVJDMjQyIiwibHIiOiIiLCJlaSI6IkFSQzI0MSwgQVJDNDEzLCBNRUUzNDQsIE1BVDEwNCwgUEhZMTAyIiwiaWkiOiJBUkM0OTEsIEFSQzQzMSwgRUNPMTA0LCBBUkMzOTQsIEFSQzMyNyJ9fQ==")));
    dd('testing nothing');
})->name('tester');

Auth::routes(['register' => false]);
Route::get('auth/google', [App\Http\Controllers\Auth\GoogleAuthController::class, 'redirectToGoogle'])->name('initiate-login');
Route::get('auth/google/callback', [App\Http\Controllers\Auth\GoogleAuthController::class, 'handleGoogleCallback'])->name('confirm-login');

Route::middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/map/saved-response-format', [App\Http\Controllers\MapperController::class, 'savedResponseFormat'])->name('saved-response-format');
    Route::get('/map/students-to-buX-username', [App\Http\Controllers\MapperController::class, 'studentMaps'])->name('student-map');
    Route::post('/map/students-to-buX-username', [App\Http\Controllers\MapperController::class, 'mapStudents'])->name('student-map');

    Route::get('/init/seed', [App\Http\Controllers\InitController::class, 'seederIndex'])->name('student-map-seeder');
    Route::get('/init/seed/ofs', [App\Http\Controllers\InitController::class, 'seedOFS'])->name('ofs-seeder');
    Route::post('/init/seed', [App\Http\Controllers\InitController::class, 'seedPart'])->name('student-map-seeder');

    Route::get('/eval', [App\Http\Controllers\EvalController::class, 'index'])->name('eval');
    Route::get('/evaluate/{year}/{semester}', [App\Http\Controllers\EvalController::class, 'evaluate'])->name('evaluate');
    
    Route::get('/eval/{type}/sample', [App\Http\Controllers\EvalController::class, 'report'])->name('eval-report-sample');

    Route::prefix('eval/report/{year}/{semester}')->group(function () {
        // Matches The "/admin/users" URL
        Route::get('/', [App\Http\Controllers\EvalController::class, 'overallReport'])->name('eval-report');
        Route::post('publish', [App\Http\Controllers\EvalController::class, 'publishReport'])->name('eval-report.publish-toggle');
        Route::get('{department}', [App\Http\Controllers\EvalController::class, 'departmentReport'])->name('eval-report.department');
        Route::get('{department}/{course}', [App\Http\Controllers\EvalController::class, 'courseReport'])->name('eval-report.course');
        Route::get('{department}/{course}/{section}', [App\Http\Controllers\EvalController::class, 'sectionReport'])->name('eval-report.section');
        Route::get('{department}/{course}/{section}/lab', [App\Http\Controllers\EvalController::class, 'labReport'])->name('eval-report.lab');
    });

    Route::post('/eval/semester-confirm', [App\Http\Controllers\EvalController::class, 'semesterConfirm'])->name('course-eval.semester-confirm');
    Route::get('/eval/factors-config/{year}/{semester}', [App\Http\Controllers\EvalController::class, 'factorsConfig'])->name('course-eval.factors-config');
    Route::post('/eval/factors-config/{year}/{semester}', [App\Http\Controllers\EvalController::class, 'factorsConfigSave'])->name('course-eval.factors-config');
    Route::post('/eval/factors-config/{year}/{semester}/copy', [App\Http\Controllers\EvalController::class, 'copyFromPrev'])->name('course-eval.factors-config.copy');
    Route::post('/eval/factors-config/{year}/{semester}/bulk', [App\Http\Controllers\EvalController::class, 'bulkUpload'])->name('course-eval.factors-config.upload');
    Route::get('/eval/matrix-config/{year}/{semester}', [App\Http\Controllers\EvalController::class, 'matrixConfig'])->name('course-eval.matrix-config');
    Route::post('/eval/matrix-config/{year}/{semester}', [App\Http\Controllers\EvalController::class, 'matrixConfigSave'])->name('course-eval.matrix-config');
    Route::get('/eval/evaluate/{year}/{semester}', [App\Http\Controllers\EvalController::class, 'evaluate'])->name('course-eval.evaluate');
    Route::post('/eval/evaluate/{year}/{semester}', [App\Http\Controllers\EvalController::class, 'storeResults'])->name('course-eval.evaluate.store');

    Route::get('/role', [App\Http\Controllers\RoleController::class, 'index'])->name('role');
    Route::get('/role/users/{role}', [App\Http\Controllers\RoleController::class, 'roleUsers'])->name('role-users');

    Route::get('/gc', function() {
        return view('gsuite-consolidate');
    });

    Route::get('/gbc', function() {
        return view('gsuite-bux-consolidate');
    });
});