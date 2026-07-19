<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/kontak', [HomeController::class, 'kirimPesan'])->name('kontak.kirim');
