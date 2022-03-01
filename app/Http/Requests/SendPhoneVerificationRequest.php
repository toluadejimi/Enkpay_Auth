<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendPhoneVerificationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'identifier' => ['required', 'string', 'exists:users,uuid']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
