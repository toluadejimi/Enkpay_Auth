<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class BankTransferRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'destination_bank' => ['required', 'string', 'max:255'],
            'account_number' => ['required', 'string', 'max:255'],
            'amount'     => ['required', 'string'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
