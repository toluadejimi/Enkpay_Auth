<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Propaganistas\LaravelPhone\PhoneNumber;
use Propaganistas\LaravelPhone\Exceptions\CountryCodeException;

class UserExistRule implements Rule
{
    protected string $phone;

    /** @throws CountryCodeException */
    public function __construct($phone, $phone_country)
    {
        $this->phone = PhoneNumber::make($phone, $phone_country)
            ->formatForCountry($phone_country);
    }

    public function passes($attribute, $value): bool
    {
        return User::select('phone')->wherePhone($this->phone)->count() > 0;
    }

    public function message(): string
    {
        return 'The user with the giving phone number does not exists.';
    }
}
