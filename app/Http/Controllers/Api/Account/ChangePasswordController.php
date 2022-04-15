<?php

namespace App\Http\Controllers\Api\Account;

use Illuminate\Http\JsonResponse;
use App\Http\Requests\ChangePasswordRequest;
use App\Actions\Account\UpdatePasswordAction;
use App\Http\Controllers\Api\BaseApiController;
use Symfony\Component\HttpFoundation\Response;

class ChangePasswordController extends BaseApiController
{
    public function __invoke(ChangePasswordRequest $request): JsonResponse
    {
        $state = UpdatePasswordAction::execute($request->toArray());

        if ($state) {
            return response()->json([
                'success' => true,
                'errors' => '',
                'message' => 'Password was successfully updated.',
                'data' => null
            ])->setStatusCode(
                Response::HTTP_OK,
                Response::$statusTexts[Response::HTTP_OK]
            );
        }

        return response()->json([
            'success' => true,
            'errors' => 'Invalid',
            'message' => 'Unable to update password, Please try again later.',
            'data' => null
        ])->setStatusCode(
            Response::HTTP_OK,
            Response::$statusTexts[Response::HTTP_OK]
        );
    }
}
