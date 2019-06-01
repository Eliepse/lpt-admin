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

use Illuminate\Support\Facades\Route;

// Auth
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Users
Route::get('/users', 'UserController@index')->name('users.index');
Route::get('/users/create', 'UserController@create')->name('users.create');
Route::post('/users', 'UserController@store')->name('users.store');


// Parents
Route::get('/parents', 'ParentController@index')->name('parents.index');
Route::get('/parents/{parent}/edit', 'ParentController@edit')->name('parents.edit');
Route::put('/parents/{parent}', 'ParentController@update')->name('parents.update');

// Students
Route::get('/students', 'StudentController@index')->name('students.index');
Route::get('/students/{student}/edit', 'StudentController@edit')->name('students.edit');
Route::put('/students/{student}', 'StudentController@update')->name('students.update');

// Family, Parents and students (children)
Route::get('/families/{family}', 'FamilyController@show')->name('family.show');
Route::get('/family/create', 'FamilyController@create')->name('family.create');
Route::get('/family/{family}/parent/create', 'ParentController@create')->name('family.parent.create');
Route::get('/family/{family}/children/create', 'StudentController@create')->name('family.children.create');
Route::post('/family', 'FamilyController@store')->name('family.store');
Route::post('/family/{family}/parent', 'ParentController@store')->name('family.parent.store');
Route::post('/family/{family}/children', 'StudentController@store')->name('family.children.store');

// Grades
Route::get('/grades', 'GradeController@index')->name('grades.index');
Route::post('/grades', 'GradeController@store')->name('grades.store');
Route::get('/grades/create', 'GradeController@create')->name('grades.create');
Route::get('/grades/{grade}', 'GradeController@show')->name('grades.show');
Route::put('/grades/{grade}', 'GradeController@update')->name('grades.update');
Route::get('/grades/{grade}/edit', 'GradeController@edit')->name('grades.edit');
Route::get('/grades/{grade}/lessons/select', 'GradeController@selectLesson')->name('grades.lessons.select');
Route::get('/grades/{grade}/lessons/{lesson}/link', 'GradeController@linkLessonForm')->name('grades.lessons.link');
Route::put('/grades/{grade}/lessons/{lesson}/link', 'GradeController@linkLesson');
Route::put('/grades/{grade}/lessons/{lesson}/unlink', 'GradeController@unlinkLesson')->name('grades.lessons.unlink');
Route::get('/grades/{grade}/classrooms/create', 'ClassroomController@create')->name('grades.classrooms.create');
Route::post('/grades/{grade}/classrooms', 'ClassroomController@store')->name('grades.classrooms.store');

// Courses
Route::get('/lessons', 'LessonController@index')->name('lessons.index');
Route::get('/lessons/create', 'LessonController@create')->name('lessons.create');
Route::get('/lessons/{lesson}/edit', 'LessonController@edit')->name('lessons.edit');
Route::post('/lessons', 'LessonController@store')->name('lessons.store');
Route::put('/lessons/{lesson}', 'LessonController@update')->name('lessons.update');

// Classrooms
Route::get('/classrooms/{classroom}', 'ClassroomController@show')->name('classrooms.show');
Route::put('/classrooms/{classroom}', 'ClassroomController@update')->name('classrooms.update');
Route::get('/classrooms/{classroom}/edit', 'ClassroomController@edit')->name('classrooms.edit');
Route::get('/classrooms/{classroom}/students/select', 'ClassroomController@selectStudent')->name('classrooms.students.select');
Route::get('/classrooms/{classroom}/students/{student}/link', 'ClassroomController@linkStudentForm')->name('classrooms.students.link');
Route::put('/classrooms/{classroom}/students/{student}/link', 'ClassroomController@linkStudent');
Route::put('/classrooms/{classroom}/students/{student}/unlink', 'ClassroomController@unlinkStudent')->name('classrooms.students.unlink');

// Other
Route::get('/home', 'Administration\\MainController@home')->name('home');
