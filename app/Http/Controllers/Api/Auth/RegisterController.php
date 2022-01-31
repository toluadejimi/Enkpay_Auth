<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserResource;
use App\Actions\Auth\RegisterUserAction;
use App\Http\Requests\TokenVerificationRequest;
use App\Http\Requests\User\UserRegistrationRequest;
use App\Actions\Auth\VerifyRegisteredAccountAction;
use Propaganistas\LaravelPhone\Exceptions\CountryCodeException;

class RegisterController
{
    /**
     * @throws CountryCodeException
     */
    public function register(UserRegistrationRequest $request): UserResource
    {
        $user = RegisterUserAction::execute($request->toArray());

        return new UserResource($user);
    }

    public function verify(TokenVerificationRequest $request): JsonResponse
    {
        $state = VerifyRegisteredAccountAction::execute(
            $request->toArray()
        );

        return $state
            ? response()->json(["message" => "Account successfully verified."], 200)
            : response()->json(["message" => "Unable to verify account"], 200);
    }
}
