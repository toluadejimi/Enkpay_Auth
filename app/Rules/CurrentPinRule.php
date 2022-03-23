<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CurrentPinRule implements Rule
{
    public function passes($attribute, $value): bool
    {
        //
    }

    public function message(): string
    {
        return 'The current pin is invalid.';
    }
}
