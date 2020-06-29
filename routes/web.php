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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/home', 'EmailData@store');
Route::get('/home','EmailData@index');
Route::post('/','SaveDraftController@draft');
Route::get('/home/send', 'mailController@send');
//Route::get('/home', 'SendEmailController@index');
//Route::post('/sendemail/send', 'SendEmailController@send');
//Route::post('/home', 'SaveDraftController@store');

