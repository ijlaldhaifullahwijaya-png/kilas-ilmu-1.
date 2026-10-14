<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuizResultController;
use Illuminate\Support\Facades\Route;

// Saat buka web pertama kali, arahkan langsung ke halaman login
Route::get('/', function () {
    return redirect()->route('login');
});

// Route Guest (hanya bisa diakses kalau BELUM login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});


Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::view('/home', 'home')->name('home');
    Route::view('/subjects', 'subjects')->name('subjects');
    Route::get('/quiz', [QuizResultController::class, 'show'])->name('quiz');
    Route::view('/progress', 'progress')->name('progress');

    Route::post('/quiz/results', [QuizResultController::class, 'store'])->name('quiz.results.store');
    Route::get('/progress/data', [QuizResultController::class, 'index'])->name('progress.data');
    Route::get('/progress/export', [QuizResultController::class, 'export'])->name('progress.export');
});