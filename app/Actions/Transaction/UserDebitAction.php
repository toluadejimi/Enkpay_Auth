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

            self::$user->debit(
                $attributes['amount'],
                [
                    'transaction_type' => $attributes['transaction_type'],
                    'description' => $attributes['description']
                ]
            );
            return true;
        }


        return false;
    }


    public static function reverseAmount(array $attributes): bool
    {
        self::$user->deposit($attributes['amount'], [
            'transaction_type' => $attributes['transaction_type'],
            'description' => 'reversal'
        ]);

        return true;
    }
}
