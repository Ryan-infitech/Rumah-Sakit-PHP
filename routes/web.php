<!-- web.php -->
<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DatauserController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\JadwalpoliklinikController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\PoliklinikController;
use App\Http\Controllers\ProfileController;
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
// Root route
Route::get('/', function () {
    return redirect()->route('login');
});

// dashboard
Route::get('/dashboard-admin', [AdminController::class, 'index'])->name('dashboard-admin');
Route::get('/dashboard-petugas', [PetugasController::class, 'index'])->name('dashboard-petugas');
Route::get('/dashboard-pasien', [PasienController::class, 'index'])->name('dashboard-pasien');

// Simplified Poliklinik routes
Route::resource('poliklinik', PoliklinikController::class);

// Simplified Dokter routes
Route::resource('dokter', DokterController::class);

// Jadwal Poliklinik
Route::get('/jadwalpoliklinik', [JadwalpoliklinikController::class, 'index'])->name('jadwalpoliklinik.index');
Route::get('/jadwalpoliklinik/create', [JadwalpoliklinikController::class, 'create'])->name('jadwalpoliklinik.create');
Route::post('/jadwalpoliklinik/add', [JadwalpoliklinikController::class, 'add'])->name('jadwalpoliklinik.add');
Route::get('/jadwalpoliklinik/{id}/edit', [JadwalpoliklinikController::class, 'edit'])->name('jadwalpoliklinik.edit');
Route::put('/jadwalpoliklinik/update/{id}', [JadwalpoliklinikController::class, 'update'])->name('jadwalpoliklinik.update');
Route::delete('/jadwalpoliklinik/{id}', [JadwalpoliklinikController::class, 'destroy'])->name('jadwalpoliklinik.destroy');

// Login routes
Route::middleware(['guest'])->group(function () {
    // Login routes
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Register routes
    Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [LoginController::class, 'register']);
});

// Logout route
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// User Routes
Route::get('/user', [DatauserController::class, 'index'])->name('user.index');
Route::get('/user/create', [DatauserController::class, 'create'])->name('user.create');
Route::post('/user/add', [DatauserController::class, 'add'])->name('user.add');
Route::get('/user/{id}/edit', [DatauserController::class, 'edit'])->name('user.edit');
Route::put('/user/{id}', [DatauserController::class, 'update'])->name('user.update');
Route::delete('/user/{id}', [DatauserController::class, 'destroy'])->name('user.destroy');

// Profile Routes
Route::get('/profile', [ProfileController::class, 'index'])->name('user.profile');
Route::put('/profile/update/{id}', [ProfileController::class, 'update'])->name('profile.update');