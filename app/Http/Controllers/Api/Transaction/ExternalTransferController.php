<?php

namespace App\Http\Controllers\Api\Transaction;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Client\RequestException;
use App\Actions\Transaction\ExternalTransferAction;
use App\Http\Requests\Transaction\ExternalTransferRequest;
use Symfony\Component\HttpFoundation\Response;

class ExternalTransferController
{
    /**
     * @throws RequestException
     */
    public function __invoke(ExternalTransferRequest $request)
    {
        $response = ExternalTransferAction::execute(
            Auth::user(),
            $request->validated()
        );

        if ($response) {
            return response()->json([
                'success' => true,
                'errors' => '',
                'message' => 'Transaction was successful',
                'data' => []
            ])->setStatusCode(
                Response::HTTP_OK,
                Response::$statusTexts[Response::HTTP_OK]
            );
        }

        return response()->json([
            'success' => false,
            'errors' => 'Failed in transaction.',
            'message' => 'Unable to complete transaction, please try again.',
            'data' => []
        ])->setStatusCode(
            Response::HTTP_OK,
            Response::$statusTexts[Response::HTTP_OK]
        );
    }
}
