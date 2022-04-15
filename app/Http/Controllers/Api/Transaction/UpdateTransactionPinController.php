<?php

namespace App\Http\Controllers\Api\Transaction;

use Symfony\Component\HttpFoundation\Response;
use App\Actions\Transaction\UpdateTransactionPinAction;
use App\Http\Requests\Transaction\UpdateTransactionPinRequest;

class UpdateTransactionPinController
{
    public function __invoke(UpdateTransactionPinRequest $request)
    {
        try {
            UpdateTransactionPinAction::execute(
                $request->validated()
            );

            return response()->json([
                'success' => true,
                'errors' => '',
                'message' => 'Transaction pin successfully updated.',
                'data' => null
            ])->setStatusCode(
                Response::HTTP_OK,
                Response::$statusTexts[Response::HTTP_OK]
            );

        }catch (\Exception $exception) {
            return response()->json([
                'success' => true,
                'errors' => 'Unable to update transaction pin.',
                'message' => 'Encounter an error why trying to update transaction pin, please try again later.',
                'data' => null
            ])->setStatusCode(
                Response::HTTP_OK,
                Response::$statusTexts[Response::HTTP_OK]
            );
        }
    }
}
