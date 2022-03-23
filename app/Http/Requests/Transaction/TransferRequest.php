<?php

namespace App\Http\Requests\Transaction;

use App\Rules\RecipientExistsRule;
use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'recipients' => ['required', 'string', new RecipientExistsRule()],
            'amount'     => ['required', 'string'],
            'description' => ['sometimes','required', 'string', 'max:255']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
