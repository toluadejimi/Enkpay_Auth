<?php

namespace App\Http\Requests\User;

use App\Enums\AccountTypeEnum;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class UserRegistrationRequest extends FormRequest
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
            'last_name' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'required', 'email', 'max:25'],
            'phone' => ['required', 'string', 'phone'],
            'phone_country' => ['sometimes','required_with:phone'],
            'device_id' => ['sometimes','required', 'string', 'max:255'],
            'password' => ['required', 'string', 'confirmed', Password::default()]
        ];
    }
}
