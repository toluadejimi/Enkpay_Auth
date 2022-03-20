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

    public static function execute(array $attributes)
    {
        self::$user->debit(
            $attributes['amount'],
            [
                'description' => $attributes['description']
            ]
        );
    }
}
