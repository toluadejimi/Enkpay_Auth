<?php

namespace App\Rules;

use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Rule;

class CurrentPinRule implements Rule
{
    public function passes($attribute, $value): bool
    {
        return Auth::user()->validatePin($value);
    }

    public function message(): string
    {
        return 'The current pin is invalid.';
    }
}
