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

        $success = new UserResource($user);

        $user->notify(new SendVerificationTokenNotification());

        return $this->sendResponse($success, 'A Verification token has been sent');
    }
}
