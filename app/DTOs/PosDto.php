<?php

namespace App\DTOs;

class PosDto
{
    public string $transaction_type;
    public string $amount;
    public string $ref;
    public string $pos_card_holder_name;
    public string $card_type;
    public string $customer_number;
    public string $customer_email;
    public string $status;
    public string $date;
    public string $uuid;
    public string $tid;//terminal Identity number

    public function __construct(
        string $transaction_type,
        string $amount,
        string $ref,
        string $pos_card_holder_name,
        string $card_type,
        string $customer_number,
        string $customer_email,
        string $status,
        string $date,
        string $uuid,
        string $tid
    ){
        $this->transaction_type = $transaction_type;
        $this->amount = $amount;
        $this->ref = $ref;
        $this->pos_card_holder_name = $pos_card_holder_name;
        $this->card_type = $card_type;
        $this->customer_number = $customer_number;
        $this->customer_email = $customer_email;
        $this->status = $status;
        $this->date = $date;
        $this->uuid = $uuid;
        $this->tid = $tid;
    }

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
