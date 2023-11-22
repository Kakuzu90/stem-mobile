<?php

use App\Http\Controllers\Api\Admin\ImageController;
use App\Http\Controllers\Api\Admin\QuestionController;
use App\Http\Controllers\Api\Teacher\ClassroomController;
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

      Route::get('image/{filename?}', ImageController::class)->name('image');
  });

  Route::prefix('teacher')
    ->middleware('auth:teacher')
    ->as('teacher.')
    ->group(function() {

      Route::get('classrooms/{classroom}/subjects', [ClassroomController::class, 'subjects'])->name('classrooms.subjects');

    });

});

