<?php

namespace App\Http\Controllers\Api\Transaction;

use Illuminate\Support\Facades\Auth;
use App\Actions\Transaction\GetBanksAction;
use Illuminate\Http\Client\RequestException;
use Symfony\Component\HttpFoundation\Response;

class GetBanksController
{
    public function __invoke()
    {
        try {
            $banks = GetBanksAction::execute(Auth::user());
        }catch (\Exception $exception){
            return response()->json([
                'success' => true,
                'errors' => 'Server error',
                'message' => 'Unable to get bank data.',
                'data' => null
            ])->setStatusCode(
                Response::HTTP_OK,
                Response::$statusTexts[Response::HTTP_OK]
            );
        }

        return response()->json([
            'success' => true,
            'errors' => '',
            'message' => 'List of banks',
            'data' => $banks
        ])->setStatusCode(
            Response::HTTP_OK,
            Response::$statusTexts[Response::HTTP_OK]
        );
    }
}
