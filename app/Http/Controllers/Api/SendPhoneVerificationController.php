<?php

namespace App\Http\Controllers\Api;

use App\Actions\SendVerificationAction;
use App\Http\Requests\SendPhoneVerificationRequest;
use App\Notifications\SendVerificationTokenNotification;

class SendPhoneVerificationController extends BaseApiController
{
    public function __invoke(SendPhoneVerificationRequest $request)
    {
        $user = SendVerificationAction::execute($request->validated());

        if ($user->exists) {
            $user->notify(new SendVerificationTokenNotification());

            return $this->sendResponse([], 'Verification token sent');
        }

        return $this->sendError('Unable to send verification token.');
    }
}
