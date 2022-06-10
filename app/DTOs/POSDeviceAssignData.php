<?php

namespace App\DTOs;

use App\Models\Pos;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class POSDeviceAssignData
{
    public function __construct(
        public string $agent,
        public string $device,
        public string $location
    ){}

    public static function fromArray(array $attributes): static
    {
        return new static(
            $attributes['agent'],
            $attributes['device'],
            $attributes['location'],
        );
    }

    public function agent(): Model
    {
        return User::query()->where('id', $this->agent)->firstOrFail();
    }

    public function device(): Model
    {
        return Pos::query()->where('id', $this->device)->firstOrFail();
    }
}
