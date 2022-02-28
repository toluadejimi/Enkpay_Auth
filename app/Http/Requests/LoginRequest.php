<?php

namespace App\Http\Requests;

use App\States\User\Active;
use Illuminate\Support\Facades\Auth;
use Propaganistas\LaravelPhone\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;
use Propaganistas\LaravelPhone\Exceptions\CountryCodeException;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'phone' => ['sometimes', 'required', 'string'],
            'email' => ['sometimes', 'required', 'email'],
            'password' => ['required', 'string']
        ];
    }

    /** @throws CountryCodeException */
    public function attempt(): bool
    {
        return $this->has('phone')
            ? $this->loginWithPhone()
            : $this->loginWithEmail();
    }

    protected function loginWithEmail(): bool
    {
        return Auth::attempt([
            'email' => $this->email,
            'password' => $this->password,
            function ($builder) {
                $builder->whereState('status', Active::class);
            }
        ]);
    }

    /** @throws CountryCodeException */
    protected function loginWithPhone(): bool
    {
        return Auth::attempt([
            'phone' => PhoneNumber::make($this->phone, 'NG')
                ->formatForCountry('NG'),
            'password' => $this->password,
            function ($builder) {
                $builder->whereState('status', Active::class);
            }
        ]);
    }

    public function authorize(): bool
    {
        return true;
    }
}
