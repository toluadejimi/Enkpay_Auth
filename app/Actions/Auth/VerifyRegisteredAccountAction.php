<?php

namespace App\Actions\Auth;

use App\Models\User;
use App\States\User\Active;
use App\Jobs\Account\CreateVirtualAccountJob;

class VerifyRegisteredAccountAction
{
    public static function execute(array $attributes): bool
    {
        $user = User::whereUuid($attributes['identifier'])->first();

        $user->markPhoneAsVerified();

        $user->status->transition(Active::class);

        // Create virtual account

        CreateVirtualAccountJob::dispatch($user);

        return $user->phoneIsVerified();
    }
}
