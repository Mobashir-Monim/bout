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
    $var = (object) ['l1' => (object) ['l2' => 'val']];
    dd("$var->l1->l2");
    return response()->json([
        'success' => true,
        'req' => request()->data[0]['gsuite'],
        'type' => gettype(request()->data)
    ]);
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
    Route::post('/init/seed', [App\Http\Controllers\InitController::class, 'seedPart'])->name('student-map-seeder');

    Route::get('/gc', function() {
        return view('gsuite-consolidate');
    });

    Route::get('/gbc', function() {
        return view('gsuite-bux-consolidate');
    });
});