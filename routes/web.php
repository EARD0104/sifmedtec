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
    Route::view('roles', 'admin.roles')->middleware('isAdmin');
    Route::view('users', 'admin.users')->middleware('isAdmin');
    Route::view('departments', 'admin.departments')->middleware('isAdmin');
    Route::view('cities', 'admin.cities')->middleware('isAdmin');
    Route::view('areas', 'admin.areas')->middleware('isAdmin');
    Route::view('questions', 'admin.questions')->middleware('isAdmin');
    Route::view('themes', 'admin.themes')->middleware('isAdmin');
    Route::view('schools', 'admin.schools')->middleware('isAdmin');
    Route::view('preferences', 'admin.preferences')->middleware('isAdmin');
    Route::view('groups', 'admin.groups');
    Route::view('password', 'admin.password');
});
