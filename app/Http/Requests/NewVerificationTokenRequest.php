<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\UserExistRule;
use Illuminate\Foundation\Http\FormRequest;
use Propaganistas\LaravelPhone\PhoneNumber;
use Propaganistas\LaravelPhone\Exceptions\CountryCodeException;

class NewVerificationTokenRequest extends FormRequest
{
    /** @throws CountryCodeException */
    public function rules(): array
    {
        return [
            'phone' => ['required', 'string', 'phone'],
            'phone_country' => ['required_with:phone', new UserExistRule($this->phone,$this->phone_country)],
        ];
    }

    public function expectedUser()
    {
        $phone = PhoneNumber::make($this->phone, $this->phone_country)
            ->formatForCountry($this->phone_country);

        return User::wherePhone($phone)->first();
    }

    public function authorize(): bool
    {
        return true;
    }
}
