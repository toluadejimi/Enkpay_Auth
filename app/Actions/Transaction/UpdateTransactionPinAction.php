<?php

namespace App\Actions\Transaction;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class UpdateTransactionPinAction
{
    public static function execute(array $attributes): bool
    {
        $state = Auth::user()->update([
            'pin' => Crypt::encrypt($attributes['pin'])
        ]);

        if ($state) {
            // send email, that pin was updated
        }

        return $state;
    }
}
