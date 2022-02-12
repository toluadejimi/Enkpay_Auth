<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;

class SendVerificationListener
{
    public function handle(Registered $event): void
    {
        $event->user->sendVerificationNotification();
    }
}
