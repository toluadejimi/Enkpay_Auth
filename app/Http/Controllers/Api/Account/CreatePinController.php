<?php

namespace App\Http\Controllers\Api\Account;

use Illuminate\Http\JsonResponse;
use App\Http\Requests\CreatePinRequest;
use App\Actions\Account\CreatePinAction;
use App\Http\Controllers\Api\BaseApiController;
use Symfony\Component\HttpFoundation\Response;

class CreatePinController extends BaseApiController
{
    public function __invoke(CreatePinRequest $request): JsonResponse
    {
        $state = '';

        try {
            $state = CreatePinAction::execute($request->toArray());
        }catch (\Exception $exception) {

        }

        if ($state === null) {
            return response()->json([
                'success' => true,
                'errors' => 'Pin already created',
                'message' => 'Pin already created for this account, you can only update when has been created. Use the right route.',
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
                'message' => 'Account transaction pin successfully created.',
                'data' => null
            ])->setStatusCode(
                Response::HTTP_OK,
                Response::$statusTexts[Response::HTTP_OK]
            );
        }

        return response()->json([
            'success' => true,
            'errors' => 'Unable to create account pin',
            'message' => 'We are unable to create your transaction pin, please try again later.',
            'data' => null
        ])->setStatusCode(
            Response::HTTP_OK,
            Response::$statusTexts[Response::HTTP_OK]
        );
    }
}
