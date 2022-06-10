<?php

namespace App\DTOs;

class POSDeviceData
{
    public string $device_id;
    public string $device_type;
    public string $status;

    public function __construct(
        string $device_id,
        string $device_type,
        string $status
    ) {
        $this->device_id = $device_id;
        $this->device_type = $device_type;
        $this->status = $status;
    }

    public static function fromArray(array $attributes): static
    {
        return new static(
            $attributes['device_id'],
            $attributes['device_type'],
            $attributes['status'],
        );
    }
}
