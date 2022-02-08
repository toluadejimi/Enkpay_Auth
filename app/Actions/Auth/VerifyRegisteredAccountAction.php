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

        //$user->verifyAccount();

        CreateVirtualAccountJob::dispatch($user);

        return $user->accountIsVerified();
    }
}
