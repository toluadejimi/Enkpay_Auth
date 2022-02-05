<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use App\Http\Requests\ResetPasswordRequest;
use App\Actions\Account\UpdatePasswordAction;

class NewPasswordController extends BaseApiController
{
    public function __invoke(ResetPasswordRequest $request): JsonResponse
    {
        $state = UpdatePasswordAction::execute($request->toArray());

        return $state
            ? $this->sendResponse([], 'Password was successfully updated')
            : $this->sendError('Unable to update password.');
    }
}
