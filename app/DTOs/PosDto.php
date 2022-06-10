<?php

namespace App\DTOs;

class PosDto
{
        public function __construct(
            public string $transaction_type,
            public string $amount,
            public string $ref,
            public string $pos_card_holder_name,
            public string $card_type,
            public string $customer_number,
            public string $customer_email,
            public string $status,
            public string $date,
            public string $uuid,
            public string $tid
        ){}

    public static function fromRequest(array $attributes): static
    {
        return new static(
            $attributes['transaction_type'],
            $attributes['amount'],
            $attributes['ref'],
            $attributes['pos_card_holder_name'],
            $attributes['card_type'],
            $attributes['customer_number'],
            $attributes['customer_email'],
            $attributes['status'],
            $attributes['date'],
            $attributes['uuid'],
            $attributes['tid'],
        );
    }
}
