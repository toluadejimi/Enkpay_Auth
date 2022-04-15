<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\NewVerificationTokenRequest;
use App\Notifications\SendVerificationTokenNotification;

class PasswordResetController extends BaseApiController
{
    public function __invoke(NewVerificationTokenRequest $request): JsonResponse
    {
        $user = $request->expectedUser();

        if ($user->exists) {

            try{
                $user->generateVerificationToken();
                $user->notify(new SendVerificationTokenNotification());

                return response()->json([
                    'success' => true,
                    'errors' => '',
                    'message' => 'Verification token has been sent.',
                    'data' => [
                        'id' => $user->uuid
                    ]
                ])->setStatusCode(
                    Response::HTTP_OK,
                    Response::$statusTexts[Response::HTTP_OK]
                );
            }catch (\Exception $exception) {
                return response()->json([
                    'success' => true,
                    'errors' => 'Unable to send verification token',
                    'message' => 'An error was encounter while sending the verification token, please try again.',
                    'data' => null
                ])->setStatusCode(
                    Response::HTTP_OK,
                    Response::$statusTexts[Response::HTTP_OK]
                );
            }

        }

        return response()->json([
            'success' => true,
            'errors' => 'Unable to send verification token',
            'message' => 'We unable to send verification token because user was not found.',
            'data' => null
        ])->setStatusCode(
            Response::HTTP_OK,
            Response::$statusTexts[Response::HTTP_OK]
        );
    }
}
