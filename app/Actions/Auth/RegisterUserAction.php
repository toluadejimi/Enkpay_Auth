<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Propaganistas\LaravelPhone\PhoneNumber;
use Propaganistas\LaravelPhone\Exceptions\CountryCodeException;

class RegisterUserAction
{
    /**
     * @throws CountryCodeException
     */
    public static function execute(array $attributes): Model|Builder
    {
        $user = User::query()->create([
            'last_name' => $attributes['last_name'],
            'first_name' => $attributes['first_name'],
            'middle_name' => $attributes['middle_name'],
            'phone_country' => $country = $attributes['phone_country'],
            'phone' => PhoneNumber::make($attributes['phone'], $country)
                ->formatForCountry($country),
            'password' => Hash::make($attributes['password']),
        ]);

        if ($user->exists) {
            event(new Registered($user));
        }

        return $user;
    }
}
