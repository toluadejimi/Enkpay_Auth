<?php

namespace App\Http\Requests\Transaction;

use App\Rules\CurrentPinRule;
use App\Rules\CurrentPasswordRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTransactionPinRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'password' => ['required', 'string', new CurrentPasswordRule()],
            'old_pin' => ['required', 'string', new CurrentPinRule()],
            'pin' => ['required', 'string', 'min:6', 'confirmed'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
