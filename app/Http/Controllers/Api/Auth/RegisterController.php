<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use App\Actions\Auth\RegisterUserAction;
use App\Http\Requests\TokenVerificationRequest;
use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\User\UserRegistrationRequest;
use App\Actions\Auth\VerifyRegisteredAccountAction;
use Propaganistas\LaravelPhone\Exceptions\CountryCodeException;

class RegisterController extends BaseApiController
{
    /**
     * @throws CountryCodeException
     */
    public function register(UserRegistrationRequest $request): JsonResponse
    {
        $user = RegisterUserAction::execute($request->toArray());

        $success['token_type'] = "Bearer";
        $success['token'] =  $user->createToken('ENKPAY_AUTH')->plainTextToken;
        $success = collect($success)->merge(new UserResource($user));

        return $this->sendResponse($success->toArray(), 'User created successfully.', 201);
    }

    public function verify(TokenVerificationRequest $request): JsonResponse
    {
        $state = VerifyRegisteredAccountAction::execute(
            $request->toArray()
        );

        return $state
            ? $this->sendResponse([], 'Account successfully verified.')
            : $this->sendError('Unable to verify account');
    }
}
