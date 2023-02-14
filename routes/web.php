<?php

use Illuminate\Support\Facades\Route;

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

Route::resource('/upload', 'UploadController');

Auth::routes();

Route::get('ajaxData','HomeController@ajax')->name('ajaxData');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/settings', 'HomeController@index')->name('/settings');
Route::get('/logout', 'HomeController@index')->name('/logout');
