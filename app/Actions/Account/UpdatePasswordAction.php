<?php

namespace App\Actions\Account;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordAction
{
    public static function execute(array $attributes): bool
    {
        $user = User::where('uuid', $attributes['identifier'])->firstOrFail();

        $state = $user->update([
            'password' => Hash::make($attributes['password'])
        ]);

        $user->deletePhoneVerificationToken();
        $user->tokens()->delete();

        return $state;
    }
}
