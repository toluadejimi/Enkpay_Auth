<?php

namespace App\Actions\Transaction;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserDebitAction
{
    protected static User $user;

    public function __construct()
    {
        self::$user = Auth::user();
    }

    public static function execute(array $attributes): bool
    {
        if (self::$user->canTransfer($attributes['amount'])) {
            return false;
        }

        self::$user->debit(
            $attributes['amount'],
            [
                'transaction_type' => $attributes['transaction_type'],
                'description' => $attributes['description']
            ]
        );

        return true;
    }
}
