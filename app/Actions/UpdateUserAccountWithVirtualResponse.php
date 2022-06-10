<?php

namespace App\Actions;

use App\Models\User;
use App\Notifications\AccountNumberCreatedNotification;

class UpdateUserAccountWithVirtualResponse
{
    public static function execute(User $user, string $virtual_account_number): void
    {
        $state = $user->update([
            'account_number' => $virtual_account_number
        ]);

        if ($state) {
            $user->notify(new AccountNumberCreatedNotification($virtual_account_number));
        }
    }
}
