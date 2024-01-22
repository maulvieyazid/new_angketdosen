<?php

use App\Http\Controllers\HasilAngketController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PertanyaanController;
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

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/hasil-angket', [HasilAngketController::class, 'index'])->name('index.hasil-angket');
    Route::get('/hasil-angket/detail/{data}', [HasilAngketController::class, 'detail'])->name('detail.hasil-angket');
    Route::get('/hasil-angket/download/excel/{smt}', [HasilAngketController::class, 'downloadExcel'])->name('download-excel.hasil-angket');


    Route::get('/kategori', [KategoriController::class, 'index'])->name('index.kategori');


    Route::get('/pertanyaan', [PertanyaanController::class, 'index'])->name('index.pertanyaan');
    Route::get('/list-pertanyaan-lainnya', [PertanyaanController::class, 'otherPertanyan'])->name('list.pertanyaan.lain');
});




Route::middleware(['auth_no_db'])->group(function () {

    Route::get('/chart/avg-nilai-per-smt/{nik}/{dari}/{hingga}', [HomeController::class, 'getAvgPerSmt'])->name('chart.avg-per-smt');
    Route::get('/chart/avg-nilai-all-dosen-per-smt/{id_fakultas}/{id_prodi}/{dari}/{hingga}', [HomeController::class, 'getAvgAllDosenPerSmt'])->name('chart.avg-all-dosen-per-smt');


    Route::post('/kategori/store', [KategoriController::class, 'store'])->name('store.kategori');
    Route::put('/kategori/update', [KategoriController::class, 'update'])->name('update.kategori');
    Route::delete('/kategori/destroy', [KategoriController::class, 'destroy'])->name('destroy.kategori');

    Route::get('/pertanyaan/correction/urut', [PertanyaanController::class, 'koreksiUrut'])->name('koreksi-urut.pertanyaan');
    Route::post('/pertanyaan/store', [PertanyaanController::class, 'store'])->name('store.pertanyaan');
    Route::put('/pertanyaan/update', [PertanyaanController::class, 'update'])->name('update.pertanyaan');
    Route::put('/pertanyaan/change-status', [PertanyaanController::class, 'changeStatus'])->name('change-status.pertanyaan');
});
