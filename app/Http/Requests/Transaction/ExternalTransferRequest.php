<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class ExternalTransferRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'amount' => ['required', 'string', 'min:1'],
            'destination_account' => ['required', 'string'],
            'destination_bank_code' => ['required', 'string'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
