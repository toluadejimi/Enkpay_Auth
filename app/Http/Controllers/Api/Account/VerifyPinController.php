<?php

namespace App\Http\Controllers\Api\Account;

use App\Http\Requests\User\VerifyPinRequest;
use Symfony\Component\HttpFoundation\Response;

class VerifyPinController
{
    public function __invoke(VerifyPinRequest $request)
    {
        $state = '';

        try {
            $state = $request->attempt();
        }catch(\Exception $exception) {
            return response()->json([
                'success' => true,
                'errors' => 'Invalid transaction pin',
                'message' => 'Your transaction pin was invalid, please try again.',
                'data' => null
            ])->setStatusCode(
                Response::HTTP_OK,
                Response::$statusTexts[Response::HTTP_OK]
            );
        }

        if ($state) {
            return response()->json([
                'success' => true,
                'errors' => '',
                'message' => 'Transaction pin is valid',
                'data' => null
            ])->setStatusCode(
                Response::HTTP_OK,
                Response::$statusTexts[Response::HTTP_OK]
            );
        }

        return response()->json([
            'success' => true,
            'errors' => 'Invalid transaction pin',
            'message' => 'Your transaction pin was invalid, please try again.',
            'data' => null
        ])->setStatusCode(
            Response::HTTP_OK,
            Response::$statusTexts[Response::HTTP_OK]
        );
    }
}
