<?php
/** API Routes */

use App\Http\Controllers\Api\Account\ActivateAndDeactivateAccountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NewPasswordController;
use App\Http\Controllers\Api\UserIndexApiController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Account\ProfileController;
use App\Http\Controllers\Api\Account\CreatePinController;
use App\Http\Controllers\Api\Auth\PasswordResetController;
use App\Http\Controllers\Api\Account\TransactionController;
use App\Http\Controllers\Api\Auth\AuthenticationController;
use App\Http\Controllers\Api\NewVerificationTokenController;
use App\Http\Controllers\Api\SendPhoneVerificationController;
use App\Http\Controllers\Api\Account\ChangePasswordController;
use App\Http\Controllers\Api\Auth\AccountTypeCollectionController;
use App\Http\Controllers\Api\Transaction\TransactionTransferController;
use App\Http\Controllers\Api\Transaction\UpdateTransactionPinController;

/** Authentication routes */
Route::prefix('auth')
    ->group(function () {
        /** Account type routes */
        Route::get('/account-type', AccountTypeCollectionController::class)
            ->name('auth.account-type');

        /** Location routes */
        Route::prefix('location')
            ->group(function () {
            //Country, State, City.
            }
        );

        /** Generate new token */
        Route::get('/new-verification-token', NewVerificationTokenController::class)
            ->name('auth.new-verification-token');

        /** Login route */
        Route::post('/login', [AuthenticationController::class, 'login']);

        /** Register routes */
        Route::prefix('/register')->group(function () {
                Route::post('/', [RegisterController::class, 'register'])->name('auth.register');
                Route::post('/send-verification', [SendPhoneVerificationController::class, '__invoke'])
                    ->name('auth.register.send.verification');
                Route::middleware('auth:sanctum')
                    ->post('/verify', [RegisterController::class, 'verify'])->name('auth.verify');
            });

        Route::prefix('/password')->group(function () {
            /** Forgot password route */
            Route::post('/forgot-password', PasswordResetController::class)->name('password.phone');

            /** Reset password route */
            Route::post('/reset-password', NewPasswordController::class)->name('password.update');
        });

        /** Logout route */
        Route::post('/logout', [AuthenticationController::class, 'logout'])
            ->name('account.logout');
    }
);

Route::middleware('auth:sanctum')
    ->prefix('account')
    ->group(function () {
        Route::middleware('account.verified')
            ->group(function () {
                /** Updates routes */
                Route::prefix('/update')
                    ->group(function () {
                        /** Change password route */
                        Route::post('/change-password', ChangePasswordController::class)
                            ->name('account.update.change-password');

                        /** Update user details */
                        /** Update pin route */
                        Route::post('/transaction-pin', UpdateTransactionPinController::class)
                            ->name('account.update.transaction-pin');
                        //
                    }
                );

                /** Transaction routes */
                Route::prefix('transaction')
                    ->group(function () {
                        Route::get('/history', [TransactionController::class, 'history'])
                            ->name('account.transaction.history');
                        Route::post('/credit', [TransactionController::class, 'credit'])
                            ->name('account.transaction.credit');
                        Route::post('/debit', [TransactionController::class, 'debit'])
                            ->name('account.transaction.debit');
                        Route::post('/transfer', [TransactionTransferController::class, '__invoke'])
                            ->name('account.transaction.transfer');
                    }
                    );

                /** Profile route */
                Route::get('/profile', [ProfileController::class, '__invoke'])
                    ->name('account.profile');

                /** Create pin route */
                Route::post('/create-pin', CreatePinController::class)
                    ->name('account.create-pin');

                /** Update account balance */
                // request virtual balance
                // post amount to deduct
                // return original virtual amount

            }
            );
    }
);

/** Administrative routes*/
Route::middleware(['auth:sanctum', 'admin'])
    ->prefix('/admin')
    ->group(function () {
        /** Users route */
        Route::get('/users', UserIndexApiController::class)
            ->name('admin.user.index');

        /** Account routes */
        Route::prefix('account')
            ->group(function () {
                Route::prefix('suspend')
                    ->group(function () {
                        Route::get('/{user:uuid}', [ActivateAndDeactivateAccountController::class, 'activate'])
                            ->name('admin.account.activate');
                        Route::get('/revoke/{user:uuid}', [ActivateAndDeactivateAccountController::class, 'deactivate'])
                            ->name('admin.account.activate');
                    }
                );
            }
        );
    }
);
