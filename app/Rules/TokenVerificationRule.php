<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\Rule;
use Propaganistas\LaravelPhone\PhoneNumber;

class TokenVerificationRule implements Rule
{
    protected User $user;

    /** Create a new rule instance. */
    public function __construct(string $identifier)
    {
        $this->user = User::select(['phone', 'phone_country'])->whereUuid($identifier)->first();
    }

    /** Determine if the validation rule passes. */
    public function passes($attribute, $value): bool
    {
        $phone = PhoneNumber::make($this->user->phone, $this->user->phone_country)
            ->formatInternational();

        $token = DB::table('phone_verification_tokens')->where('phone', '=', $phone)->value('token');

        return $value === $token;
    }

    /** Get the validation error message. */
    public function message(): string
    {
        return 'Token sent was invalid.';
    }
}
