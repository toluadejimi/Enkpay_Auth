<?php

namespace App\Notifications;

use App\Services\Sms\SmsChannel;
use App\Services\Sms\SmsMessage;
use Illuminate\Notifications\Notification;

class AccountNumberCreatedNotification extends Notification
{
    public string $account_number;

    public function __construct(string $account_number)
    {
        $this->account_number = $account_number;
    }

    public function via(mixed $notifiable): array
    {
        return [SmsChannel::class];
    }

    public function toSms(mixed $notifiable): SmsMessage
    {
        return (new SmsMessage)
            ->to("{$notifiable->phone_number}")
            ->line("Hi {$notifiable->full_name}, Your virtual account number is:   {$this->account_number}.");
    }
}
