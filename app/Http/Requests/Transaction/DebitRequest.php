<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class DebitRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'uuid' => ['required', 'string', 'exists:users,uuid'],
            'transaction_type' => ['required','string'],
            'amount' => ['required', 'string'],
            'description' => ['sometimes', 'required', 'string', 'max:255']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
