<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class DebitRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'amount' => ['required', 'string'],
            'description' => ['required', 'string', 'max:255']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
