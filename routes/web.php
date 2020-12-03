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