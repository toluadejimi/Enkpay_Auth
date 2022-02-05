<?php

namespace App\Http\Controllers\Api\Account;

use App\Models\User;

class UpdateUserAccountWithVirtualResponse
{
    public static function execute(User $user, $attributes)
    {
        // update here
        $user->virtual_account()->create([

        ]);

        // Send notification with details of account number
    }
}
