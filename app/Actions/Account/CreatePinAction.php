<?php

namespace App\Actions\Account;

use Illuminate\Support\Facades\Auth;

class CreatePinAction
{
    public static function execute(array $attribute): bool|null
    {
        if (Auth::user()->hasCreatePin()) {
            return null;
        }

        return Auth::user()->update([
            'pin' => encrypt($attribute['pin'])
        ]);
    }
}
