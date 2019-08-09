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

use App\Http\Controllers\Administration\ScheduleStudentController;
use App\Http\Controllers\Administration\SettingsController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\DuplicateScheduleController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;


// Auth
Route::post('logout', 'Auth\LoginController@logout')->name('logout');


// Staff
Route::get('/staff', [StaffController::class, 'index']);


// Parents
Route::get('/parents/{parent}/edit', [ParentController::class, 'edit'])->name('parents.edit');
Route::put('/parents/{parent}', [ParentController::class, 'update'])->name('parents.update');


// Students
Route::get('/students', [StudentController::class, 'index'])->name('students.index');
Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
Route::put('/students/{student}', [StudentController::class, 'update'])->name('students.update');


// Family, Parents and students (children)
Route::get('/families/create', [FamilyController::class, 'create'])->name('families.create');
Route::post('/families', [FamilyController::class, 'store'])->name('families.store');
Route::get('/families/{family}', [FamilyController::class, 'show'])->name('families.show');
Route::get('/families/{family}/student/create', [StudentController::class, 'create'])->name('students.create');
Route::post('/families/{family}/student', [StudentController::class, 'store'])->name('students.store');
Route::get('/families/{family}/parents/create', [ParentController::class, 'create'])->name('parents.create');
Route::post('/families/{family}/parents', [ParentController::class, 'store'])->name('parents.store');


// Lessons
Route::get('/lessons', [LessonController::class, 'index'])->name('lessons.index');
Route::get('/lessons/create', 'LessonController@create')->name('lessons.create');
Route::get('/lessons/{lesson}/edit', 'LessonController@edit')->name('lessons.edit');
Route::post('/lessons', 'LessonController@store')->name('lessons.store');
Route::put('/lessons/{lesson}', 'LessonController@update')->name('lessons.update');


// Classrooms
Route::get('classrooms', [ClassroomController::class, 'index'])->name('classrooms.index');
Route::post('classrooms', [ClassroomController::class, 'store'])->name('classrooms.store');
Route::get('classrooms/create', [ClassroomController::class, 'create'])->name('classrooms.create');
Route::get('/classrooms/{classroom}', [ClassroomController::class, 'show'])->name('classrooms.show');
Route::put('/classrooms/{classroom}', [ClassroomController::class, 'update'])->name('classrooms.update');
Route::get('/classrooms/{classroom}/edit', 'ClassroomController@edit')->name('classrooms.edit');


// Schedules
Route::post('/schedules', [ScheduleController::class, 'store'])->name('schedules.store');
Route::get('/schedules/{schedule}', [ScheduleController::class, 'show'])->name('schedules.show');
Route::put('/schedules/{schedule}', [ScheduleController::class, 'update'])->name('schedules.update');
Route::get('/schedules/{schedule}/promptDuplicate', [DuplicateScheduleController::class, 'prompt'])->name('schedules.promptDuplicate');
Route::get('/schedules/{schedule}/duplicate', [DuplicateScheduleController::class, 'form'])->name('schedules.duplicate');
Route::post('/schedules/{schedule}/duplicate', [DuplicateScheduleController::class, 'store']);
Route::get('/schedules/{schedule}/students/select', [ScheduleStudentController::class, 'select'])->name('schedules.students.select');
Route::put('/schedules/{schedule}/students/{student}', [ScheduleStudentController::class, 'link'])->name('schedules.students.link');
Route::get('/schedules/{schedule}/students/{student}/edit', [ScheduleStudentController::class, 'edit'])->name('schedules.students.edit');


// Offices
Route::get('/offices', [OfficeController::class, 'index'])->name('offices.index');
Route::get('/offices/create', [OfficeController::class, 'create'])->name('offices.create');
Route::post('/offices', [OfficeController::class, 'store'])->name('offices.store');
Route::get('/offices/{office}', [OfficeController::class, 'show'])->name('offices.show');
Route::get('/offices/{office}/schedules/create', [ScheduleController::class, 'create'])->name('offices.schedules.create');

// Settings
Route::get('/settings', [SettingsController::class, 'general'])->name('settings');
//Route::put('/settings/action/maintenance', [SettingsController::class, 'toggleMaintenance'])->name('settings.action.toggleMaintenance');


// Other
Route::get('/home', 'Administration\\MainController@home')->name('home');
