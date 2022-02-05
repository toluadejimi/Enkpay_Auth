<?php

namespace App\Http\Requests;

use App\Rules\TokenVerificationRule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'identifier' => ['required', 'string', 'exists:users,uuid'],
            'token' => ['required', 'string', new TokenVerificationRule($this->identifier)],
            'password' => ['required', 'string', 'confirmed', Password::default()]
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
