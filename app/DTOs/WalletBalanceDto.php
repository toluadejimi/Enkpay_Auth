<?php

namespace App\DTOs;

class WalletBalanceDto
{
    public string $amount;

    public function __construct(string $amount)
    {
        $this->amount = $amount;
    }

    public static function fromRequest(array $attributes): static
    {
        return new static(
            $attributes['amount']
        );
    }
}
