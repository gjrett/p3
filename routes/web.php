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


/*
 * Misc "static" pages
 */
Route::view('/', 'welcome');
Route::view('/login', 'login');
Route::view('/about', 'about');
Route::view('/contact', 'contact');

/*
 * Birthday forms
 */
Route::get('/birthdays/create', 'BirthdayController@create');
Route::post('/birthdays/process', 'BirthdayController@process');
Route::get('/birthdays/show', 'BirthdayController@show');
Route::get('/birthdays/store', 'BirthdayController@store');

# Show the search form
Route::get('/birthdays/search', 'BirthdayController@search');


Route::get('/birthdays', 'BirthdayController@index');

/**
 * Practice
 */
Route::any('/practice/{n?}', 'PracticeController@index');

