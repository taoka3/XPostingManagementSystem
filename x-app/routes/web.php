<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\XPostController;
use App\Http\Controllers\ScheduledPostController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', function () {
    return view('welcome');
});

// Auth Routes
Route::middleware('guest')->group(function () {
    // Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    // Route::post('register', [RegisterController::class, 'register']);
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
});

Route::post('logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Dashboard Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/x-post', [XPostController::class, 'index'])->name('x-post.index');
    Route::post('/dashboard/x-post', [XPostController::class, 'store'])->name('x-post.store');

    Route::get('/dashboard/x-post/scheduled', [ScheduledPostController::class, 'index'])->name('x-post.scheduled');
    Route::delete('/dashboard/x-post/scheduled/{post}', [ScheduledPostController::class, 'destroy'])->name('x-post.destroy');
});
