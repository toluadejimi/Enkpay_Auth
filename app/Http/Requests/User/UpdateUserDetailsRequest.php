<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserDetailsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'date_of_birth'     =>  ['required', 'date'],
            'gender'            =>  ['required', 'string'],
            'email'             =>  ['required', 'string', 'email', 'max:255'],
            'address_line_1'    =>  ['required', 'string', 'max:500'],
            'city'              =>  ['required', 'string', 'max:255'],
            'state'             =>  ['required', 'string', 'max:255'],
            'country'           =>  ['required', 'string', 'max:255'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
