<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HeartRateController;

// ── Login ──
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::get('/index', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// ── Register ──
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// ── Dashboard ──
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

// ── History ──
Route::get('/history', [HomeController::class, 'history'])->name('history');

// ── Logout ──
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ── Heart Rate Data Storage ──
Route::post('/heart-rate/store', [HeartRateController::class, 'store']);

Route::get('/ping', function () {
    return 'pong';
});