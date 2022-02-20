<?php

namespace App\Http\Controllers\Api;

use App\Actions\SendVerificationAction;
use App\Http\Requests\SendPhoneVerificationRequest;

class SendPhoneVerificationController extends BaseApiController
{
    public function __invoke(SendPhoneVerificationRequest $request)
    {
        $user = SendVerificationAction::execute($request->validated());

        if ($user->exists) {
            //
        }

        return $this->sendError('Unable to send verification token.');
    }
}
