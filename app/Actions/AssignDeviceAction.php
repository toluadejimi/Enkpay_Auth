<?php

namespace App\Actions;

use App\DTOs\POSDeviceAssignData;

class AssignDeviceAction
{
    public static function execute(POSDeviceAssignData $request): bool
    {
        return $request->device()->update([
            'user_id' => $request->agent()->id,
            'location' => $request->location
        ]);
    }
}
