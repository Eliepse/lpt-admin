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

use App\Http\Controllers\Admin\StaffUserPasswordController;
use App\Http\Controllers\Administration\HomeController;
use App\Http\Controllers\Administration\ScheduleSubscriptionController;
use App\Http\Controllers\Administration\SettingsController;
use App\Http\Controllers\Administration\StaffController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DuplicateScheduleController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;


// Auth
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Staff
Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
Route::get('/staff/create', [StaffController::class, 'create'])->name('staff.create');
Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');
Route::get('/staff/{staff}/edit', [StaffController::class, 'edit'])->name('staff.edit');
Route::put('/staff/{staff}', [StaffController::class, 'update'])->name('staff.update');
Route::get('/staff/{staff}/password', [StaffUserPasswordController::class, 'form'])->name('staff.edit.password');
Route::put('/staff/{staff}/password', [StaffUserPasswordController::class, 'update']);


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
Route::get('/lessons/create', [LessonController::class, 'create'])->name('lessons.create');
Route::get('/lessons/{lesson}/edit', [LessonController::class, 'edit'])->name('lessons.edit');
Route::post('/lessons', [LessonController::class, 'store'])->name('lessons.store');
Route::put('/lessons/{lesson}', [LessonController::class, 'update'])->name('lessons.update');


// Courses
Route::get('courses', [CourseController::class, 'index'])->name('courses.index');
Route::post('courses', [CourseController::class, 'store'])->name('courses.store');
Route::get('courses/create', [CourseController::class, 'create'])->name('courses.create');
Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');
Route::put('/courses/{course}', [CourseController::class, 'update'])->name('courses.update');
Route::get('/courses/{course}/edit', [CourseController::class, 'edit'])->name('courses.edit');
Route::get('/courses/{course}/delete', [CourseController::class, 'delete'])->name('courses.delete');
Route::delete('/courses/{course}', [CourseController::class, 'destroy'])->name('courses.destroy');


// Schedules
Route::post('/schedules', [ScheduleController::class, 'store'])->name('schedules.store');
Route::get('/schedules/create', [ScheduleController::class, 'create'])->name('schedules.create');
Route::get('/schedules/{schedule}', [ScheduleController::class, 'show'])->name('schedules.show');
Route::get('/schedules/{schedule}/edit', [ScheduleController::class, 'edit'])->name('schedules.edit');
Route::put('/schedules/{schedule}', [ScheduleController::class, 'update'])->name('schedules.update');
Route::get('/schedules/{schedule}/promptDuplicate', [DuplicateScheduleController::class, 'prompt'])->name('schedules.promptDuplicate');
Route::get('/schedules/{schedule}/duplicate', [DuplicateScheduleController::class, 'form'])->name('schedules.duplicate');
Route::post('/schedules/{schedule}/duplicate', [DuplicateScheduleController::class, 'store']);
Route::get('/schedules/{schedule}/students/select', [ScheduleSubscriptionController::class, 'select'])->name('schedules.students.select');
Route::put('/schedules/{schedule}/students/{student}', [ScheduleSubscriptionController::class, 'link'])->name('schedules.students.link');
Route::get('/schedules/{schedule}/students/{student}/unlink', [ScheduleSubscriptionController::class, 'confirmUnlink'])->name('schedules.students.unlink');
Route::delete('/schedules/{schedule}/students/{student}', [ScheduleSubscriptionController::class, 'unlink']);
Route::get('/schedules/{schedule}/students/{student}/edit', [ScheduleSubscriptionController::class, 'edit'])->name('schedules.students.edit');
Route::get('/schedules/{schedule}/delete', [ScheduleController::class, 'delete'])->name('schedules.delete');
Route::delete('/schedules/{schedule}', [ScheduleController::class, 'trash'])->name('schedules.trash');


// Campuses
Route::get('/campuses', [CampusController::class, 'index'])->name('campuses.index');
Route::get('/campuses', [CampusController::class, 'index'])->name('campuses.index');
Route::get('/campuses/create', [CampusController::class, 'create'])->name('campuses.create');
Route::post('/campuses', [CampusController::class, 'store'])->name('campuses.store');
Route::get('/campuses/{campus}', [CampusController::class, 'show'])->name('campuses.show');
Route::get('/campuses/{campus}/edit', [CampusController::class, 'edit'])->name('campuses.edit');
Route::put('/campuses//{campus}', [CampusController::class, 'update'])->name('campuses.update');

// Settings
Route::get('/settings', [SettingsController::class, 'general'])->name('settings');
//Route::put('/settings/action/maintenance', [SettingsController::class, 'toggleMaintenance'])->name('settings.action.toggleMaintenance');


// Other
Route::get('/', HomeController::class)->name('dashboard');
