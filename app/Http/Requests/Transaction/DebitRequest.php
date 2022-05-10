<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class DebitRequest extends FormRequest
{
    protected array $transactionType = [
        'airtime', 'data', 'in-transfer', 'out-transfer',
        'cash-in', 'dstv', 'gotv', 'startime', 'flight', 'electric',
        'education', 'insurance', 'exchange'
    ];
    public function rules(): array
    {
        return [
            'uuid' => ['required', 'string', 'exists:users,uuid'],
            'transaction_type' => ['required','string', 'in:'.$this->getTransactionTypeArray()],
            'amount' => ['required', 'string'],
            'description' => ['sometimes', 'required', 'string', 'max:255']
        ];
    }

    protected function getTransactionTypeArray(): string
    {
        return implode(',', $this->transactionType);
    }

    public function authorize(): bool
    {
        return true;
    }
}
