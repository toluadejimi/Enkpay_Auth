<?php

namespace App\Models\Settings;

use Spatie\LaravelSettings\Settings;

class ApplicationSettings extends Settings
{
    public bool $features;
    public ?string $bills_commission;
    public ?string $transfer_commission;

    public static function group(): string
    {
        return "application";
    }
}
