<?php

namespace App\Notifications;

use App\Services\Sms\SmsChannel;
use App\Services\Sms\SmsMessage;
use Illuminate\Notifications\Notification;

class SendVerificationTokenNotification extends Notification
{
    /** Get the notification's delivery channels. */
    public function via(mixed $notifiable): array
    {
        return [SmsChannel::class];
    }

    /** Get the sms representation of the notification. */
    public function toSms(mixed $notifiable): SmsMessage
    {
        return (new SmsMessage)
            ->to("{$notifiable->phone_number}")
            ->line("Hi {$notifiable->full_name} {$notifiable->getVerificationToken()} is your verification code.");
    }
}
