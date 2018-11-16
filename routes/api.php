<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->group(function() {
    Route::resource('departments', 'DepartmentController');
    Route::resource('cities', 'CityController');
    Route::resource('roles', 'RoleController');
    Route::resource('users', 'UserController');
    Route::resource('areas', 'AreaController');
    Route::resource('themes', 'ThemeController');
    Route::resource('questions', 'QuestionController');
    Route::resource('answers', 'AnswerController');
    Route::resource('schools', 'SchoolController');
    Route::resource('preferences', 'PreferenceController');
    Route::resource('groups', 'GroupController');
    Route::resource('groups/{group}/themes', 'GroupThemeController');
    Route::resource('months', 'MonthController');
    Route::resource('passwords', 'PasswordController');
});
