<?php

namespace App\Actions\Account;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UpdatePasswordAction
{
    public static function execute(array $attributes): bool
    {
        return Auth::user()->update([
            'password' => Hash::make($attributes['password'])
        ]);
    }
}
