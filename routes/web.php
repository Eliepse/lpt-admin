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
    'reset' => false,
    'verify' => false,
]);

// Users
Route::get('/users', 'UserController@index')->name('users.index');
Route::get('/users/create', 'UserController@create')->name('users.create');
Route::post('/users', 'UserController@store')->name('users.store');


// Parents
Route::get('/parents', 'ParentController@index')->name('parents.index');

// Students
Route::get('/students', 'StudentController@index')->name('students.index');

// Family, Parents and students (children)
Route::get('/families/{family}', 'FamilyController@show')->name('family.show');
Route::get('/family/create', 'FamilyController@create')->name('family.create');
Route::get('/family/{family}/parent/create', 'ParentController@create')->name('family.parent.create');
Route::get('/family/{family}/children/create', 'StudentController@create')->name('family.children.create');
Route::post('/family', 'FamilyController@store')->name('family.store');
Route::post('/family/{family}/parent', 'ParentController@create')->name('family.parent.store');
Route::post('/family/{family}/children', 'StudentController@store')->name('family.children.store');

// Grades
Route::get('/grades', 'GradeController@index')->name('grades.index');
Route::get('/grades/create', 'GradeController@create')->name('grades.create');
Route::post('/grades', 'GradeController@store')->name('grades.store');

// Courses
Route::get('/courses', 'CourseController@index')->name('courses.index');
Route::get('/courses/create', 'CourseController@create')->name('courses.create');
Route::post('/courses', 'CourseController@store')->name('courses.store');

// Other
Route::get('/home', function () {
    return view('home');
})->middleware(['auth', 'type:admin,teacher'])->name('home');

// This is only temporary
Route::redirect('/', '/login');
