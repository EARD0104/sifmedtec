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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', 'HomeController@index')->name('home');
Auth::routes();
Route::resource('evaluations', 'EvaluationController');
Route::get('evaluation-questions', 'EvaluationQuestionController@index');
Route::get('groups/{group}', 'GroupController@show');

Route::middleware(['auth'])->group(function ()
{
    Route::view('roles', 'admin.roles');
    Route::view('users', 'admin.users');
    Route::view('departments', 'admin.departments');
    Route::view('cities', 'admin.cities');
    Route::view('areas', 'admin.areas');
    Route::view('questions', 'admin.questions');
    Route::view('themes', 'admin.themes');
    Route::view('schools', 'admin.schools');
    Route::view('preferences', 'admin.preferences');
    Route::view('groups', 'admin.groups');
    Route::view('password', 'admin.password');
});
