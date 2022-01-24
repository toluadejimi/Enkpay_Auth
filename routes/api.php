<?php
/** API Routes */

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\RegisterController;

/** Registration user (phone, password) */
/** Verify token sent (token) */
// By text token or By voice token (text is default)

/** Authentication (login, logout) */

/** Forgot request password (phone) */
/** Verify reset password token sent (token) */
/** Reset password (password)*/

/** Register routes */
Route::controller(RegisterController::class)
    ->prefix('auth/register')
    ->as('auth.')
    ->group(function () {
       Route::post('/', 'register')->name('register');
    });


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
