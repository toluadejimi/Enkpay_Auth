<?php

namespace App\Http\Requests\Transaction;

use App\Rules\RecipientExistsRule;
use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'phone_number' => ['required', 'string', new RecipientExistsRule()],
            'destination_name' => ['required', 'string', 'max:255'],
            'amount'     => ['required', 'string'],
            'description' => ['sometimes','required', 'string', 'max:255']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
