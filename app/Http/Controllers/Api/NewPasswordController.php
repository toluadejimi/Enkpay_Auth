<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use App\Http\Requests\ResetPasswordRequest;
use App\Actions\Account\UpdatePasswordAction;
use Symfony\Component\HttpFoundation\Response;

class NewPasswordController extends BaseApiController
{
    public function __invoke(ResetPasswordRequest $request): JsonResponse
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
