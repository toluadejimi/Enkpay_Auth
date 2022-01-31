<?php
/** API Routes */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NewPasswordController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Account\CreatePinController;
use App\Http\Controllers\Api\Auth\PasswordResetController;
use App\Http\Controllers\Api\Auth\AuthenticationController;
use App\Http\Controllers\Api\Account\ChangePasswordController;

/** Authentication routes */
Route::prefix('auth')->group(function () {
    /** Login route */
    Route::post('/login', [AuthenticationController::class, 'login']);

    /** Register routes */
    Route::prefix('/register')->group(function () {
            Route::post('/', [RegisterController::class, 'register'])->name('auth.register');
            Route::post('/verify', [RegisterController::class, 'verify'])->name('auth.verify');
        });

    Route::prefix('/password')->group(function () {
        /** Forgot password route */
        Route::post('/forgot-password', PasswordResetController::class)->name('password.phone');

        /** Reset password route */
        Route::post('/reset-password', NewPasswordController::class)->name('password.update');
    });

    /** Authenticated routes */
    Route::middleware('auth:sanctum')->prefix('account')->group(function () {
        /** Updates routes */
        Route::prefix('/update')->group(function () {
            /** Change password route */
            Route::post('/change-password', ChangePasswordController::class)->name('account.update.change-password');
        });

        /** Create pin route */
        Route::post('/create-pin', CreatePinController::class)->name('account.create-pin');

        /** Logout route */
        Route::post('/logout', [AuthenticationController::class, 'logout'])->name('account.logout');
    });
});
