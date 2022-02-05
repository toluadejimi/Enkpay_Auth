<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Services\Sms\SmsChannel;
use App\Services\Sms\SmsMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class VerificationNotification extends Notification implements ShouldQueue
{
    use Queueable;

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
            ->line("Hi {$notifiable->full_name}, {$notifiable->getVerificationToken()} is your verification code.");
    }
}
