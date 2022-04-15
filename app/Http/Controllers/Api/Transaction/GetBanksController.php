<?php

namespace App\Http\Controllers\Api\Transaction;

use Illuminate\Support\Facades\Auth;
use App\Actions\Transaction\GetBanksAction;
use Illuminate\Http\Client\RequestException;

class GetBanksController
{
    public function __invoke()
    {
        try {
            $banks = GetBanksAction::execute(Auth::user());
        }catch (\Exception $exception){
            return response()->json([
                'success' => false,
                'errors' => true,
                'message' => 'Unable to get bank data.',
                'data' => []
            ]);
        }

        return response()->json([
            'success' => true,
            'errors' => '',
            'message' => 'List of banks',
            'data' => $banks
        ]);
    }
}
