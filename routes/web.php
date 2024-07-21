<?php

use App\Http\Controllers\CabangController;
use App\Http\Controllers\DataAnggotaController;
use App\Http\Controllers\DasboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TingnkatanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome')->middleware('Loginv2');
Route::get('/dashboard',[DasboardController::class, 'index'])->name('dashboard.index')->middleware('Login');
Route::post('/login',[LoginController::class, 'loginPost'])->name('loginPost');
Route::delete('/logout',[LoginController::class, 'destroy'])->name('logout');
Route::get('/cabang', [CabangController::class, 'index'])->name('cabang.index');
Route::put('/cabang/{cabang}/update', [CabangController::class, 'update'])->name('cabang.update');
Route::put('/tingkatan/{tingkatan}/update', [TingnkatanController::class, 'update'])->name('tingkatan.update');
Route::delete('/tingkatan/{tingkatan}/destroy', [TingnkatanController::class, 'destroy'])->name('tingkatan.destroy');
Route::delete('/anggota/{anggota}/destroy', [DataAnggotaController::class, 'destroy'])->name('anggota.destroy');
Route::delete('/cabang/{cabang}/destroy', [CabangController::class, 'destroy'])->name('cabang.destroy');
Route::put('/anggota/{anggota}/update', [DataAnggotaController::class, 'update'])->name('anggota.update');
Route::post('/cabang', [CabangController::class, 'store'])->name('cabang.store');
Route::get('/tingkatan', [TingnkatanController::class, 'index'])->name('tingkatan.index');
Route::post('/tingkatan', [TingnkatanController::class, 'store'])->name('tingkatan.store');
Route::get('/anggota', [DataAnggotaController::class, 'index'])->name('anggota.index');
Route::post('/anggota', [DataAnggotaController::class, 'store'])->name('anggota.store');