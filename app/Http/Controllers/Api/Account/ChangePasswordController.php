<?php

namespace App\Http\Controllers\Api\Account;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Actions\Account\UpdatePasswordAction;

class ChangePasswordController extends Controller
{
    public function __invoke(ChangePasswordRequest $request): JsonResponse
    {
        $state = UpdatePasswordAction::execute($request->toArray());

        return $state
            ? response()->json(["message" => "Password was successfully updated"], 201)
            : response()->json(["message" => "Unable to update password."]);
    }
}
