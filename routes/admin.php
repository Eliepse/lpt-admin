<?php

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

use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\DuplicateScheduleController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;

// Auth
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Users
//Route::get('/users', 'UserController@index')->name('users.index');
//Route::get('/users/create', 'UserController@create')->name('users.create');
//Route::post('/users', 'UserController@store')->name('users.store');

// Staff
Route::get('/staff', [StaffController::class, 'index']);

// Parents
//Route::get('/parents', 'ParentController@index')->name('parents.index');
//Route::get('/parents/{parent}/edit', 'ParentController@edit')->name('parents.edit');
//Route::put('/parents/{parent}', 'ParentController@update')->name('parents.update');

// Students
//Route::get('/students', 'StudentController@index')->name('students.index');
//Route::get('/students/{student}/edit', 'StudentController@edit')->name('students.edit');
//Route::put('/students/{student}', 'StudentController@update')->name('students.update');

// Family, Parents and students (children)
Route::get('/families/create', [FamilyController::class, 'create'])->name('family.create');
Route::post('/families', [FamilyController::class, 'store'])->name('family.store');
Route::get('/families/{family}', [FamilyController::class, 'show'])->name('family.show');
//Route::get('/family/{family}/parent/create', 'ParentController@create')->name('family.parent.create');
//Route::get('/family/{family}/children/create', 'StudentController@create')->name('family.children.create');
//Route::post('/family/{family}/parent', 'ParentController@store')->name('family.parent.store');
//Route::post('/family/{family}/children', 'StudentController@store')->name('family.children.store');

// Lessons
Route::get('/lessons', [LessonController::class, 'index'])->name('lessons.index');
Route::get('/lessons/create', 'LessonController@create')->name('lessons.create');
Route::get('/lessons/{lesson}/edit', 'LessonController@edit')->name('lessons.edit');
Route::post('/lessons', 'LessonController@store')->name('lessons.store');
Route::put('/lessons/{lesson}', 'LessonController@update')->name('lessons.update');

// Classrooms
Route::post('classrooms', [ClassroomController::class, 'store'])->name('classroom.store');
Route::get('classrooms/create', [ClassroomController::class, 'create'])->name('classroom.create');
Route::get('/classrooms/{classroom}', [ClassroomController::class, 'show'])->name('classrooms.show');
Route::put('/classrooms/{classroom}', [ClassroomController::class, 'update'])->name('classrooms.update');
Route::get('/classrooms/{classroom}/edit', 'ClassroomController@edit')->name('classrooms.edit');
//Route::get('/classrooms/{classroom}/students/select', 'ClassroomController@selectStudent')->name('classrooms.students.select');
//Route::get('/classrooms/{classroom}/students/{student}/link', 'ClassroomController@linkStudentForm')->name('classrooms.students.link');
//Route::put('/classrooms/{classroom}/students/{student}/link', 'ClassroomController@linkStudent');
//Route::put('/classrooms/{classroom}/students/{student}/unlink', 'ClassroomController@unlinkStudent')->name('classrooms.students.unlink');

// Schedules
Route::post('/schedules', [ScheduleController::class, 'store'])->name('schedule.store');
Route::put('/schedules/{schedule}', [ScheduleController::class, 'update'])->name('schedule.update');
Route::get('/schedules/{schedule}/promptDuplicate', [DuplicateScheduleController::class, 'prompt'])->name('schedule.promptDuplicate');
Route::get('/schedules/{schedule}/duplicate', [DuplicateScheduleController::class, 'form'])->name('schedule.duplicate');
Route::post('/schedules/{schedule}/duplicate', [DuplicateScheduleController::class, 'store']);

// Offices
Route::get('/offices/{office}', [OfficeController::class, 'show'])->name('office.show');
Route::get('/offices/{office}/schedule/create', [ScheduleController::class, 'create'])->name('office.schedule.create');

// Other
Route::get('/home', 'Administration\\MainController@home')->name('home');
