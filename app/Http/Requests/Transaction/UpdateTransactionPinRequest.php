<?php

namespace App\Http\Requests\Transaction;

use App\Rules\CurrentPinRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTransactionPinRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'old_pin' => ['required', 'string', new CurrentPinRule()],
            'pin' => ['required', 'string', 'confirmed'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
