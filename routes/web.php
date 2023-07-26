<?php

use App\Http\Controllers\VerifikasiKendaraanController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::resource('/upload', 'UploadController');


Route::get('ajaxData','HomeController@ajax')->name('ajaxData');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/settings', 'HomeController@index')->name('/settings');
Route::get('/logout', 'HomeController@index')->name('/logout');
Route::get('/viewverifikasi', [VerifikasiKendaraanController::class, 'viewverifikasi'])->name('viewverifikasi');
// Route::post('/generate-qr-code', 'VerificationController@generateQRCode')->name('generate.qr.code');
Route::post('/create-qr-link', 'VerifikasiKendaraanController@createQRLink')->name('create.qr.link');
Route::get('/generate-qr-link', function () {
    return view('create_qr_link');
})->name('generate.qr.link');
Route::get('/download-qr-code', 'VerifikasiKendaraanController@downloadQRCode')->name('create.qr.link.download');
