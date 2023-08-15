<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\AdminLogoutController;
use App\Http\Controllers\Auth\AdminRegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\TeacherAuthenticatedSessionController;
use App\Http\Controllers\Auth\TeacherLogoutController;
use App\Http\Controllers\Auth\TeacherRegisterController;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Route;

// // Login
// Route::middleware('guest')->group(function () {
//     Route::get('login', [LoginController::class, 'create'])->name('login');
//     Route::post('login', [LoginController::class, 'store']);
// });

// // Register Admin
// Route::middleware('guest')->prefix('admin')->group(function () {
//     Route::get('register', [AdminRegisterController::class, 'create'])->name('register');
//     Route::post('register', [AdminRegisterController::class, 'store']);
// });

// // Register Teacher
// Route::middleware('guest')->prefix('teacher')->group(function () {
//     Route::get('register', [TeacherRegisterController::class, 'create'])
//         ->name('teacher.register');

//     Route::post('register', [TeacherRegisterController::class, 'store'])
//         ->name('teacher.register.post');
// });

// // Logout Admin
// Route::middleware('auth')->prefix('admin')->group(function () {
//     Route::post('logout', [AdminLogoutController::class , 'destroy'])
//         ->name('logout');
// });

// // Logout Teacher
// Route::middleware('auth:teacher')->prefix('teacher')->group(function () {
//     Route::post('logout', [TeacherLogoutController::class, 'destroy'])
//         ->name('teacher.logout');
// });
