<?php

namespace App\Http\Controllers\Api\Account;

use App\Http\Requests\User\VerifyPinRequest;

class VerifyPinController
{
    public function __invoke(VerifyPinRequest $request)
    {
        return response()->json([
            'status' => $state = $request->attempt(),
            'message' => $state ? 'Transaction was valid' : 'Invalid transaction pin'
        ]);
    }
}
