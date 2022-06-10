<?php

namespace App\DTOs;

use App\Models\Pos;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class POSDeviceAssignData
{
    public string $agent;
    public string $device;
    public string $location;

    public function __construct(
        string $agent, string $device, string $location
    ){
           $this->agent = $agent;
           $this->device = $device;
           $this->location = $location;
    }

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
