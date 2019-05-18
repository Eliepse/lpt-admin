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

\Illuminate\Support\Facades\Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);

Route::get('/grades/create', 'GradeController@create')->name('grades.create');
Route::post('/grades', 'GradeController@store')->name('grades.store');
Route::get('/grades', 'GradeController@index')->name('grades.index');

Route::get('/courses', 'CourseController@index')->name('courses.index');
Route::get('/courses/create', 'CourseController@create')->name('courses.create');
Route::post('/courses', 'CourseController@store')->name('courses.store');

Route::get('/home', function () {
    return view('home');
})->middleware(['auth', 'type:admin,teacher'])->name('home');

// This is only temporary
Route::redirect('/', '/login');
