<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\NewVerificationTokenRequest;
use App\Notifications\SendVerificationTokenNotification;

class PasswordResetController extends BaseApiController
{
    public function __invoke(NewVerificationTokenRequest $request): JsonResponse
    {
        $user = $request->expectedUser();

        $user->generateVerificationToken();

        $user->notify(new SendVerificationTokenNotification());

        return $this->sendResponse(['id' => $user->uuid], 'A Verification token has been sent');
    }
}
