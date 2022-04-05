<?php

namespace App\Actions\Transaction;

use Illuminate\Support\Facades\Auth;

class UpdateTransactionPinAction
{
    public static function execute(array $attributes): bool
    {
        $state = Auth::user()->update([
            'pin' => encrypt($attributes['pin'])
        ]);

        if ($state) {
            // send email, that pin was updated
        }

        return $state;
    }
}
