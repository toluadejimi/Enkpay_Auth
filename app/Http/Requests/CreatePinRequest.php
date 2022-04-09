<?php

namespace App\Http\Requests;

use App\Rules\CurrentPasswordRule;
use App\Rules\CurrentPhoneRule;
use Illuminate\Foundation\Http\FormRequest;

class CreatePinRequest extends FormRequest
{
    /** Determine if the user is authorized to make this request. */
    public function authorize(): bool
    {
        return true;
    }

    /** Get the validation rules that apply to the request. */
    public function rules(): array
    {
        return [
            'phone' => ['required', 'string', 'phone:NG', new CurrentPhoneRule()],
            'pin' => ['required', 'string', 'size:4', 'confirmed'],
        ];
    }
}
