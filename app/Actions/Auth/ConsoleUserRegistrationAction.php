<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ConsoleUserRegistrationAction
{
    public static function execute(array $attributes): User
    {
        return User::query()->create([
            //'name' => $attributes['name'],
            'email' => $attributes['email'],
            'password' => Hash::make($attributes['password']),
        ]);
    }
}
