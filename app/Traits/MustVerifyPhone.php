<?php

namespace App\Traits;

use JetBrains\PhpStorm\Pure;
use Propaganistas\LaravelPhone\PhoneNumber;

trait MustVerifyPhone
{
    /**
     * Determine if the user has verified their phone number.
     *
     * @return bool
     */
    public function hasVerifiedPhone(): bool
    {
        return ! is_null($this->phone_verified_at);
    }

    /**
     * Mark the given user's phone as verified.
     *
     * @return bool
     */
    public function markPhoneAsVerified(): bool
    {
        return $this->forceFill([
            'phone_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    public function getPhoneNumber(): string
    {
        return "{$this->isd_code}{$this->phone}";
    }

    #[Pure]
    public function getPhoneNumberAttribute(): string
    {
        return $this->getPhoneNumber();
    }

    public function getPhoneForVerification(): string
    {
        return $this->phone;
    }
}
