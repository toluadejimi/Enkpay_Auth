<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Propaganistas\LaravelPhone\Exceptions\CountryCodeException;

class CurrentPhoneRule implements Rule
{
    /** @throws CountryCodeException */
    public function passes($attribute, $value): bool
    {
        return Auth::user()->validatePhone($value);
    }

    public function message(): string
    {
        return 'The validation error message.';
    }
}
