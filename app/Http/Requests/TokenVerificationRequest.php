<?php

namespace App\Http\Requests;

use App\Rules\TokenVerificationRule;
use Illuminate\Foundation\Http\FormRequest;

class TokenVerificationRequest extends FormRequest
{
    /** Determine if the user is authorized to make this request. */
    public function authorize(): bool
    {
        return true;
    }

    /** Get the validation rules that apply to the request. */
    public function rules(): array
    {
        return [
            'identifier' => ['required', 'string', 'exists:users,uuid'],
            'token' => ['required', 'string', new TokenVerificationRule($this->request)]
        ];
    }
}
