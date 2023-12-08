<?php

use App\Http\Controllers\Gate\AngketDosenController;
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

Route::middleware(['check.semester', 'check.angket_api_key'])->group(function () {
    Route::get('/angket_dosen_gate/get_data_krs_mhs', [AngketDosenController::class, 'getDataKrsMhs'])->name('gate.angket.get_krs_mhs');
});

Route::middleware(['check.semester'])->group(function () {
    Route::get('/angket_dosen_gate/get_daftar_pertanyaan_angket_dosen', [AngketDosenController::class, 'getDaftarPertanyaanAngketDosen'])->name('gate.angket.get_daftar_pertanyaan');
});
