<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class WalletBalanceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'amount' => ['required', 'string'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
