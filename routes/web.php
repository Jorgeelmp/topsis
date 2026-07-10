<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfessionalController;

Route::redirect('/', '/login');

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
    Route::post('/login', [AuthController::class, 'authenticate']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');

    Route::controller(ProfessionalController::class)->group(function () {
        Route::get('/become-professional', [ProfessionalController::class, 'showBecomeProfessionalForm'])->name('professional.become');
        Route::post('/become-professional', [ProfessionalController::class, 'becomeProfessional']);
    });
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
