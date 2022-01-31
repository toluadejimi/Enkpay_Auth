<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendVerificationListener implements ShouldQueue
{
    public function handle(Registered $event): void
    {
        $event->user->sendVerificationNotification();
    }
}
