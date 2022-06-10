<?php

namespace App\DTOs;

class WalletBalanceDto
{
    public function __construct(
        public string $amount
    ){}

    public static function fromRequest(array $attributes): static
    {
        return new static(
            $attributes['amount']
        );
    }
}
