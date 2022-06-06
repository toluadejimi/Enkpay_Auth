<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Propaganistas\LaravelPhone\PhoneNumber;
use Propaganistas\LaravelPhone\Exceptions\CountryCodeException;

class ConsoleUserRegistrationAction
{
    /** @throws CountryCodeException */
    public static function execute(array $attributes): User
    {
        return User::query()->create([
            'first_name' => $attributes['first_name'],
            'last_name' => $attributes['last_name'],
            'email' => $attributes['email'],
            'phone_country' => $country = $attributes['phone_country'] ?? 'NG',
            'phone' => PhoneNumber::make($attributes['phone'], $country)
                ->formatForCountry($country),
            'password' => Hash::make($attributes['password']),
            'type' => 'admin',
        ]);
    }
}
