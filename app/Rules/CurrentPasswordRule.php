<?php

namespace App\Rules;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Validation\Rule;

class CurrentPasswordRule implements Rule
{
    /** Determine if the validation rule passes. */
    public function passes($attribute, mixed $value): bool
    {
        return Hash::check($value, Auth::user()->password);
    }

    /** Get the validation error message. */
    public function message(): string
    {
        return 'Invalid current password';
    }
}
