<?php

namespace App\Actions\Account;

use App\Models\User;

class UpdateUserDetailsAction
{
    public static function execute(User $user, array $attributes)
    {
        $state = $user->update($attributes);

        if ($state) {
            // fire event
        }

        return $state;
    }
}
