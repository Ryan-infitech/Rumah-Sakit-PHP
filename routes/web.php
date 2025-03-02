<!-- web.php -->
<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\PoliklinikController;
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
// dashboard
Route::get('/dashboard-admin', [AdminController::class, 'index'])->name('dashboard-admin');
Route::get('/dashboard-petugas', [PetugasController::class, 'index'])->name('dashboard-petugas');
Route::get('/dashboard-pasien', [PasienController::class, 'index'])->name('dashboard-pasien');

// Simplified Poliklinik routes
Route::resource('poliklinik', PoliklinikController::class);

// Simplified Dokter routes
Route::resource('dokter', DokterController::class);