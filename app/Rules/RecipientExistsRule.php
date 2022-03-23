<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class RecipientExistsRule implements Rule
{
    public function passes($attribute, $value): bool
    {
        //
    }

    public function message(): string
    {
        return 'This recipient do not exists.';
    }
}
