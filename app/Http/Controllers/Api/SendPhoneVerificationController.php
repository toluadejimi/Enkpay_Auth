<?php

namespace App\Http\Controllers\Api;

use App\Actions\SendVerificationAction;
use App\Http\Requests\SendPhoneVerificationRequest;
use App\Notifications\SendVerificationTokenNotification;
use Symfony\Component\HttpFoundation\Response;

class SendPhoneVerificationController extends BaseApiController
{
    public function __invoke(SendPhoneVerificationRequest $request)
    {
        $user = SendVerificationAction::execute($request->validated());

        if ($user->exists) {
            $user->notify(new SendVerificationTokenNotification());

            return response()->json([
                'success' => true,
                'errors' => '',
                'message' => 'Verification token sent',
                'data' => []
            ])->setStatusCode(
                Response::HTTP_OK,
                Response::$statusTexts[Response::HTTP_OK]
            );
        }

        return response()->json([
            'success' => false,
            'errors' => 'Unable to send verification token',
            'message' => 'Unable to send verification token to your contact, please try again.',
            'data' => []
        ])->setStatusCode(
            Response::HTTP_OK,
            Response::$statusTexts[Response::HTTP_OK]
        );
    }
}
