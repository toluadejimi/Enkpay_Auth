<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class PosRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            /*transaction-type
            amount
            Ref
            Customer name Full name (Pos card holder name)
            Card type
            Customer number
            Customer email
            Status
            Date
            Uuid of app user
            tid(terminal Identity number)*/
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
