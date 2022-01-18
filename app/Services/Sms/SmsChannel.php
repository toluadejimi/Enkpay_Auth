<?php

namespace App\Services\Sms;

use Illuminate\Notifications\Notification;

class SmsChannel
{
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toSms($notifiable);

        $message->send();
    }
}
