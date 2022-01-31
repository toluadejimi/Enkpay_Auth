<?php

namespace App\Http\Requests\User;

use App\Rules\ValidOTPRule;
use Illuminate\Foundation\Http\FormRequest;

class AccountVerificationRequest extends FormRequest
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
            'uuid' => ['required', 'string'],
            'otp_token' => ['required', 'string', new ValidOTPRule()]
        ];
    }
}
