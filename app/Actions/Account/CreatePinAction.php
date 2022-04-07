<?php

namespace App\Actions\Account;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class CreatePinAction
{
    public static function execute(array $attribute): bool|null
    {
        if (Auth::user()->hasCreatePin()) {
            return null;
        }

        return Auth::user()->update([
            'pin' => Crypt::encrypt($attribute['pin'])
        ]);
    }
}
