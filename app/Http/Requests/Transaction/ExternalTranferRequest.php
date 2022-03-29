<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class ExternalTranferRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'amount' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
