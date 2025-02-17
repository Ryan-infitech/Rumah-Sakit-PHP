<?php

use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/services', [PublicController::class, 'services'])->name('services');
Route::get('/doctors', [PublicController::class, 'doctors'])->name('doctors');
Route::get('/contact', [PublicController::class, 'contact'])->name('contact');