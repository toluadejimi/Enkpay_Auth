<?php

namespace App\Enums;

use Closure;
use Illuminate\Support\Str;
use Spatie\Enum\Laravel\Enum;

/**
 * @method static self user()
 * @method static self agent()
 * @method static self admin()
 */
final class AccountTypeEnum extends Enum
{
    protected static function labels(): Closure
    {
        return fn (string $name) => Str::headline($name.' account type');
    }
}
