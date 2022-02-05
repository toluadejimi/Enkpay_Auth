<?php

namespace App\Http\Controllers\Api\Account;

use Illuminate\Http\JsonResponse;
use App\Http\Requests\CreatePinRequest;
use App\Actions\Account\CreatePinAction;
use App\Http\Controllers\Api\BaseApiController;

class CreatePinController extends BaseApiController
{
    public function __invoke(CreatePinRequest $request): JsonResponse
    {
        $state = CreatePinAction::execute($request->toArray());

        return $state
            ? $this->sendResponse([], 'Account Pin successfully created.')
            : $this->sendError('Unable to create account pin.');
    }
}
