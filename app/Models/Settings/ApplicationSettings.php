<?php

namespace App\Models\Settings;

use Spatie\LaravelSettings\Settings;

class ApplicationSettings extends Settings
{
    public bool $pos;
    public bool $data;
    public bool $flight;
    public bool $transfer;
    public bool $exam_card;
    public bool $pay_bills;
    public bool $exchange;
    public bool $buy_ticket;
    public bool $insurance;
    public bool $buy_airtime;
    public ?string $bills_commission;
    public ?string $transfer_commission;

    public static function group(): string
    {
        return "application";
    }
}
