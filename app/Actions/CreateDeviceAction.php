<?php

namespace App\Actions;

use App\Models\Pos;
use App\DTOs\POSDeviceData;

class CreateDeviceAction
{
    public static function execute(POSDeviceData $request): Pos
    {
        return Pos::query()->create([
            'device_id' => $request->device_id,
            'device_type'   => $request->device_type,
            'status'    => $request->status,
        ]);
    }
}
