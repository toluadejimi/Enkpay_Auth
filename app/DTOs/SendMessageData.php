<?php

namespace App\DTOs;

class SendMessageData
{
    public string $title;
    public string $body;

    public function __construct(string $title, string $body)
    {
        $this->title = $title;
        $this->body = $body;
    }

    public static function fromArray(array $attributes): static
    {
        return new static(
            $attributes['title'],
            $attributes['body']
        );
    }
}
