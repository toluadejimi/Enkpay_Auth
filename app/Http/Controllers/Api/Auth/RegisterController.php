<?php

namespace App\Http\Controllers\Api\Auth;

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
        $success['full_name'] =  $user->full_name;

        return $this->sendResponse($success, 'User created successfully.');
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
