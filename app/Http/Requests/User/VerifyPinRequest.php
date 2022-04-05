<?php

namespace App\Http\Requests\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class VerifyPinRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'pin' => ['required', 'string'],
        ];
    }

    public function attempt(): bool
    {
        return Auth::user()->validatePin($this->pin);
    }

    public function authorize(): bool
    {
        return true;
    }
}
