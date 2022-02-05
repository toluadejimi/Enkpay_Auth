<?php

namespace App\DTOs;

use Spatie\DataTransferObject\DataTransferObject;

class SmsResponse extends DataTransferObject
{
    public string $code;

    public string $user;

    public string $balance;

    public string $message;

    public string $message_id;
}
