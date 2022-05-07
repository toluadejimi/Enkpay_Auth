<?php

namespace App\Actions\Transaction;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserCreditAction
{
    protected static User $user;

    public function __construct()
    {
        self::$user = Auth::user();
    }

    public static function execute(array $attributes): bool
    {
        //$this->user->credit($amount);

        return true;
    }
}
