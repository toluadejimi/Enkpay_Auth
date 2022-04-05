<?php

namespace App\Http\Requests\Transaction;

use App\Rules\CurrentPinRule;
use App\Rules\CurrentPhoneRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTransactionPinRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'phone' => ['required', 'string', 'phone:NG', new CurrentPhoneRule()],
            'old_pin' => ['required', 'string', new CurrentPinRule()],
            'pin' => ['required', 'string', 'min:6', 'confirmed'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
