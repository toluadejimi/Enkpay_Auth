<?php

namespace App\DTOs;

class SendMessageData
{
    public function __construct(
        public string $title,
        public string $body
    ){}

    public static function fromArray(array $attributes): static
    {
        return new static(
            $attributes['title'],
            $attributes['body']
        );
    }
}
