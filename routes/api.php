<?php

use App\Http\Controllers\UserSimogaController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\KebunController;
use App\Http\Controllers\PabrikController;
use App\Http\Controllers\PemasokController;
use App\Http\Controllers\SortasiPlasmaController;
use App\Http\Controllers\HargaController;
use App\Http\Controllers\PelanggaranController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('loginuser', [UserSimogaController::class, 'loginuser'])->name('pabrik.loginuser');

Route::get('pabrik/{kode_plasma}', [PabrikController::class, 'index'])->name('pabrik.index');
Route::get('home/{kode_plasma}', [PabrikController::class, 'home'])->name('pabrik.home');

//pemasok
Route::get('pemasok', [PemasokController::class, 'index'])->name('pemasok.index');
Route::patch('pemasok/{id}', [PemasokController::class, 'update']);
Route::delete('pemasok/{id}', [PemasokController::class, 'delete']);

//grade
Route::get('grade', [GradeController::class, 'index'])->name('grade.index');
Route::patch('grade/{id}', [GradeController::class, 'update']);
Route::delete('grade/{id}', [GradeController::class, 'delete']);

//sortasi_plasma
Route::get('sortasi_plasma/{kode_plasma}', [SortasiPlasmaController::class, 'index'])->name('grade.index');
Route::patch('sortasi_plasma/{id}', [SortasiPlasmaController::class, 'update']);
Route::delete('sortasi_plasma/{id}', [SortasiPlasmaController::class, 'delete']);

//attribute static table
Route::get('/rayon', [KebunController::class, 'getPlasma']);
Route::get('/kebun/{idRayon}', [KebunController::class, 'getKebun']);
Route::get('/jenispemasok/{idKebun}', [KebunController::class, 'getJenis']);

//TBS Dipulangkan
Route::patch('sortasi_plasma/tbs_dipulangkan/{id}', [SortasiPlasmaController::class, 'tbsDipulangkan']);

//harga
Route::get('sortasi_plasma/harga/{id}', [HargaController::class, 'index']);
Route::get('report_harga/{kode_plasma}', [HargaController::class, 'reportHarga'])->name('harga.reportHarga');

Route::get('export_sortasi/{kode_plasma}/{str}/{end}', [SortasiPlasmaController::class, 'export'])->name('sortasi.export');
Route::get('viewDataExport/{kode_plasma}/{str}/{end}', [SortasiPlasmaController::class, 'viewDataExport'])->name('sortasi.viewDataExport');

// pelanggaran 
Route::get('/pelanggaran', [PelanggaranController::class, 'index']);
