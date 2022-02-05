<?php

namespace App\Http\Requests\User;

use App\Enums\AccountTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use JetBrains\PhpStorm\ArrayShape;

class UserRegistrationRequest extends FormRequest
{
    /** Determine if the user is authorized to make this request. */
    public function authorize(): bool
    {
        return true;
    }

    /** Get the validation rules that apply to the request. */
    #[ArrayShape(['last_name' => "string[]", 'first_name' => "string[]", 'middle_name' => "string[]", 'phone' => "string[]", 'phone_country' => "string[]", 'account_type' => "string[]", 'password' => "array"])] public function rules(): array
    {
        return [
            'last_name' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['sometimes', 'string', 'max:255'],
            'phone' => ['required', 'string', 'phone'],
            'phone_country' => ['required_with:phone'],
            'account_type' => ['required', 'string', 'enum:'.AccountTypeEnum::class],
            'password' => ['required', 'string', 'confirmed', Password::default()]
        ];
    }
}
