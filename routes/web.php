<?php

use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\ClassroomController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GradeLevelController;
use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\Admin\SchoolYearController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Auth\Admin\AuthController;
use App\Http\Controllers\Auth\Student\AuthController as StudentAuthController;
use App\Http\Controllers\Auth\Teacher\AuthController as TeacherAuthController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\Student\HomeController;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboardController;
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

Route::middleware('guest:student')
    ->controller(StudentAuthController::class)
    ->as('student.')
    ->group(function() {
    Route::get('/', 'index')->name('login');
    Route::get('stored', 'login')->name('login.store');
});

Route::middleware('auth:student')
    ->prefix('student')
    ->as('student.')
    ->group(function() {
        Route::get('/', function() {
            return redirect()->route('student.home');
        });

        Route::get('logout', [StudentAuthController::class, 'logout'])->name('logout');

        Route::get('home', HomeController::class)->name('home');
});

Route::prefix('administrator')
    ->as('admin.')
    ->group(function() {

        Route::get('/', function() {
            return redirect()->route('admin.dashboard');
        });

        Route::middleware('guest:web')
        ->controller(AuthController::class)
        ->group(function() {
            Route::get('login', 'index')->name('login');
            Route::post('login/stored', 'login')->name('login.store');
        });


        Route::middleware('auth:web')
        ->group(function() {
            Route::controller(FileController::class)->group(function() {
                Route::get('template-student', 'student')->name('template.student');
                Route::get('template-teacher', 'teacher')->name('template.teacher');
            });
            Route::get('logout', [AuthController::class, 'logout'])->name('logout');

            Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
            Route::apiResource('school-year', SchoolYearController::class);
            Route::apiResource('grade-level', GradeLevelController::class);
            Route::apiResource('sections', SectionController::class);
            Route::get('classrooms/{classroom}/subjects', [ClassroomController::class, 'subjects'])->name('classrooms.subjects');
            Route::post('classrooms/{classroom}/subject', [ClassroomController::class, 'subject'])->name('classrooms.subject');
            Route::apiResource('classrooms', ClassroomController::class);
            Route::apiResource('subjects', SubjectController::class);
            Route::apiResource('teachers', TeacherController::class);
            Route::post('teachers/import', [TeacherController::class, 'import'])->name('teachers.import');
            Route::apiResource('students', StudentController::class);
            Route::post('students/import', [StudentController::class, 'import'])->name('students.import');
            Route::get('students/{student}/{classroom}', [StudentController::class, 'subjects'])->name('students.subjects');
            Route::apiResource('announcements', AnnouncementController::class);
            Route::get('modules/{module}/{classroom}/subjects', [ModuleController::class, 'subjects'])->name('modules.subjects');
            Route::apiResource('modules', ModuleController::class);
            Route::apiResource('activities', ActivityController::class);
        });

});

Route::prefix('teacher')
    ->as('teacher.')
    ->group(function() {
        
        Route::get('/', function() {
            return redirect()->route('teacher.dashboard');
        });

        Route::middleware('guest:teacher')
        ->controller(TeacherAuthController::class)
        ->group(function() {
            Route::get('login', 'index')->name('login');
            Route::post('login/stored', 'login')->name('login.store');
        });

        Route::middleware('auth:teacher')
        ->group(function() {
            Route::get('logout', [TeacherAuthController::class, 'logout'])->name('logout');

            Route::get('dashboard', [TeacherDashboardController::class, 'index'])->name('dashboard');
        });

});



Route::fallback(function() {
    abort(404);
});