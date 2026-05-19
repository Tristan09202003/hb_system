<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

// ── Login ──
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::get('/index', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// ── Register ──
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// ── Dashboard ──
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

// ── Patients ──
Route::get('/patients', [HomeController::class, 'patients'])->name('patients');
Route::get('/patients/{id}/history', [HomeController::class, 'patientHistory'])->name('patients.history');

// ── History ──
Route::get('/history', [HomeController::class, 'history'])->name('history');


Route::get('/forgot-password',  [ForgotPasswordController::class, 'showForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendLink'])->name('password.email');

Route::get('/reset-password/{token}',  [ResetPasswordController::class, 'showForm'])->name('password.reset');
Route::post('/reset-password',         [ResetPasswordController::class, 'reset'])->name('password.update');

// ── Logout ──
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');