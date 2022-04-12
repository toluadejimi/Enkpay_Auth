<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use App\Http\Requests\NewVerificationTokenRequest;
use App\Notifications\SendVerificationTokenNotification;
use Symfony\Component\HttpFoundation\Response;

class NewVerificationTokenController extends BaseApiController
{
    public function __invoke(NewVerificationTokenRequest $request): JsonResponse
    {
        $request->expectedUser()->notify(new SendVerificationTokenNotification());

        return response()->json([
            'success' => true,
            'errors' => null,
            'message' => 'Verification token sent',
            'data' => null
        ])->setStatusCode(
            Response::HTTP_OK,
            Response::$statusTexts[Response::HTTP_OK]
        );
    }
}
