<?php

use App\Http\Controllers\Api\FileController;;
use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\Api\ResultController;
use App\Http\Controllers\Api\Student\ClassroomController as StudentClassroomController;
use App\Http\Controllers\Api\Student\ExamController;
use App\Http\Controllers\Api\Student\MyClassController as StudentMyClassController;
use App\Http\Controllers\Api\Teacher\ClassroomController;
use App\Http\Controllers\Api\Teacher\MyClassController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::as('api.')->group(function() {

  Route::prefix('administrator')
    ->middleware('auth:web')
    ->as('admin.')
    ->group(function() {

      Route::prefix('activities')->as('activities.')
        ->controller(QuestionController::class)
        ->group(function() {
        Route::get('{activity}', 'index')->name('index');
        Route::post('{activity}/store', 'store')->name('store');
      });

      Route::get('image/{filename?}', [FileController::class, 'index'])->name('image');
  });

  Route::prefix('teacher')
    ->middleware('auth:teacher')
    ->as('teacher.')
    ->group(function() {

      Route::prefix('activities')->as('activities.')
        ->controller(QuestionController::class)
        ->group(function() {
        Route::get('{activity}', 'index')->name('index');
        Route::post('{activity}/store', 'store')->name('store');
      });

      Route::controller(ResultController::class)
        ->prefix('result')
        ->group(function() {

          Route::get('{activity}', 'index')->name('result.index');
          Route::get('{activity}/{classroom}/{subject}/students', 'students')->name('result.students');

      });

      Route::get('image/{filename?}', [FileController::class, 'index'])->name('image');
      Route::get('classrooms/{classroom}/subjects', [ClassroomController::class, 'subjects'])->name('classrooms.subjects');

      Route::controller(MyClassController::class)
          ->prefix('my-class')
          ->as('my-class.')
          ->group(function() {

            Route::get('school-years', 'year')->name('year');
            Route::get('school-years/{year?}', 'index')->name('index');

      });
      
    });

    Route::prefix('student')
      ->middleware('auth:student')
      ->as('student.')
      ->group(function() {

        Route::controller(StudentMyClassController::class)
          ->prefix('my-class')
          ->as('my-class.')
          ->group(function() {
            Route::get('school-years', 'year')->name('year');
            Route::get('school-years/{year?}', 'index')->name('index');
        });

        Route::controller(StudentClassroomController::class)
          ->prefix('classroom')
          ->as('classroom.')
          ->group(function() {
            Route::get('{classroom?}/subject/{subject?}', 'index')->name('index');
            Route::get('{classroom?}/subject/{subject?}/modules', 'module')->name('module');
            Route::get('{classroom?}/subject/{subject?}/{type}', 'activity')->name('activity');
        });

        Route::controller(ExamController::class)
          ->prefix('exam')
          ->as('exam.')
          ->group(function() {
            Route::get('{activity}/classroom/{classroom}/subject/{subject}', 'index')->name('index');
            Route::get('{activity}/classroom/{classroom}/subject/{subject}/questions', 'questions')->name('questions');
        });

        Route::get('image/{filename?}',[FileController::class, 'index'])->name('image.index');
        Route::get('file/{path}',[FileController::class, 'module'])->name('file.module');

    });

});

