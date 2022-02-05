<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use App\Http\Requests\NewVerificationTokenRequest;
use App\Notifications\SendVerificationTokenNotification;

class NewVerificationTokenController extends BaseApiController
{
    public function __invoke(NewVerificationTokenRequest $request): JsonResponse
    {
        $request->expectedUser()->notify(new SendVerificationTokenNotification());

        return $this->sendResponse([], 'Verification token sent');
    }
}
