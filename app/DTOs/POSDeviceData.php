<?php

namespace App\DTOs;

class POSDeviceData
{
    public function __construct(
        public string $device_id,
        public string $device_type,
        public string $status
    ) {}

    public static function fromArray(array $attributes): static
    {
        return new static(
            $attributes['device_id'],
            $attributes['device_type'],
            $attributes['status'],
        );
    }
}
