<?php

namespace App\Actions\Account;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UpdatePasswordAction
{
    public static function execute(array $attributes): bool
    {
        $user = Auth::user();
        $state = $user->update([
            'password' => Hash::make($attributes['password'])
        ]);

        // Revoke all tokens
        $user->tokens()->delete();

        return $state;
    }
}
