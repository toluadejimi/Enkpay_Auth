<?php

namespace App\Http\Controllers\Api\Account;

use Illuminate\Http\JsonResponse;
use App\Http\Requests\ChangePasswordRequest;
use App\Actions\Account\UpdatePasswordAction;
use App\Http\Controllers\Api\BaseApiController;

class ChangePasswordController extends BaseApiController
{
    public function __invoke(ChangePasswordRequest $request): JsonResponse
    {
        $state = UpdatePasswordAction::execute($request->toArray());

        return $state
            ? $this->sendResponse([], 'Password was successfully updated')
            : $this->sendError('Unable to update password.');
    }
}
