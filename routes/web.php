<?php

use App\Http\Controllers\EvaluasiBeasiswaController;
use App\Http\Controllers\HasilAngketController;
use App\Http\Controllers\HistoriController;
use App\Http\Controllers\KesimpulanBeasiswaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SyaratBeasiswaController;
use App\Http\Controllers\SyaratPesertaBeasiswaController;
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

    Route::get('/', function () {
        return view('home');
    })->name('home');

    Route::get('/hasil-angket', [HasilAngketController::class, 'index'])->name('index.hasil-angket');
});
