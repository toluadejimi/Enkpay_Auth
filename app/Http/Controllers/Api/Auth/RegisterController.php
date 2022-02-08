<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserResource;
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
    /**
     * @OA\Post(
     *     path="/auth/register",
     *     summary="Register User",
     *     tags={"Register a user"},
     *    @OA\Parameter(
     *           name="last_name",
     *           in="query",
     *           required=true,
     *           @OA\Schema(
     *                 type="string"
     *           )
     *     ),
     *    @OA\Parameter(
     *           name="first_name",
     *           in="query",
     *           required=true,
     *           @OA\Schema(
     *                 type="string"
     *           )
     *     ),
     *    @OA\Parameter(
     *           name="middle_name",
     *           in="query",
     *           required=false,
     *           @OA\Schema(
     *                 type="string"
     *           )
     *     ),
     *    @OA\Parameter(
     *           name="phone_country",
     *           in="query",
     *           required=false,
     *           @OA\Schema(
     *                 type="string"
     *           )
     *     ),
     *    @OA\Parameter(
     *           name="phone",
     *           in="query",
     *           required=true,
     *           @OA\Schema(
     *                 type="string"
     *           )
     *     ),
     *    @OA\Parameter(
     *           name="account_type",
     *           in="query",
     *           required=false,
     *           @OA\Schema(
     *                 type="string"
     *           )
     *     ),
     *    @OA\Parameter(
     *           name="password",
     *           in="query",
     *           required=true,
     *           @OA\Schema(
     *                 type="string"
     *           )
     *     ),
     *    @OA\Parameter(
     *           name="password_confirmation",
     *           in="query",
     *           required=true,
     *           @OA\Schema(
     *                 type="string"
     *           )
     *     ),
     *    @OA\Response(
     *      response=200,
     *       description="Success",
     *   ),
     * )
     */
    public function register(UserRegistrationRequest $request): JsonResponse
    {
        $user = RegisterUserAction::execute($request->validated());

        $success['token_type'] = "Bearer";
        $success['token'] =  $user->createToken('ENKPAY_AUTH')->plainTextToken;
        $success = collect($success)->merge(new UserResource($user));

        return $this->sendResponse($success->toArray(), 'User created successfully.', 201);
    }


    /**
     * @OA\Post(
     *     path="/auth/register/verify",
     *     summary="Verify a register User",
     *     tags={"User verification"},
     *    @OA\Parameter(
     *           name="token",
     *           in="query",
     *           required=true,
     *           @OA\Schema(
     *                 type="string"
     *           )
     *     ),
     *    @OA\Parameter(
     *           name="identifier",
     *           in="query",
     *           description="user uuid, sent during registration"
     *           required=true,
     *           @OA\Schema(
     *                 type="string"
     *           )
     *     ),
     *
     */
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
