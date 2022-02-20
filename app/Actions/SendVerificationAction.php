<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class SendVerificationAction
{
    public static function execute(array $attributes): User|Builder
    {
        $user = User::query()
            ->where('uuid', $attributes['identifier'])
            ->firstOrFail();

        $user->sendVerificationNotification();

        return $user;
    }
}
