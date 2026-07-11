<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfessionalController;
use App\Http\Controllers\ServiceCategoryController;
use Illuminate\Support\Facades\Route;

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

    Route::resource('criterias', CriteriaController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::resource('service-categories', ServiceCategoryController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
