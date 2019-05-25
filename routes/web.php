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
\Illuminate\Support\Facades\Auth::routes([
    'register' => false,
    'verify' => false,
]);

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
Route::get('/grades/create', 'GradeController@create')->name('grades.create');
Route::get('/grades/{grade}', 'GradeController@show')->name('grades.show');
Route::get('/grades/{grade}/edit', 'GradeController@edit')->name('grades.edit');
Route::post('/grades', 'GradeController@store')->name('grades.store');
Route::put('/grades/{grade}', 'GradeController@update')->name('grades.update');
Route::put('/grades/{grade}/students/{student}/link', 'GradeController@linkStudent')->name('grades.students.link');
Route::put('/grades/{grade}/students/{student}/unlink', 'GradeController@unlinkStudent')->name('grades.students.unlink');

// Courses
Route::get('/courses', 'CourseController@index')->name('courses.index');
Route::get('/courses/create', 'CourseController@create')->name('courses.create');
Route::get('/courses/{course}/edit', 'CourseController@edit')->name('courses.edit');
Route::post('/courses', 'CourseController@store')->name('courses.store');
Route::put('/courses/{course}', 'CourseController@update')->name('courses.update');

// Other
Route::get('/home', function () {
    return view('home');
})->middleware(['auth', 'roles:admin,teacher'])->name('home');

// This is only temporary
Route::redirect('/', '/login');
