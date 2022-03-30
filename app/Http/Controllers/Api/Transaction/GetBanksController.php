<?php

namespace App\Http\Controllers\Api\Transaction;

use Illuminate\Support\Facades\Auth;
use App\Actions\Transaction\GetBanksAction;
use Illuminate\Http\Client\RequestException;

class GetBanksController
{
    /** @throws RequestException */
    public function __invoke()
    {
        $banks = GetBanksAction::execute(Auth::user());

        return response()->json([
            'data' => $banks
        ]);
    }
}
