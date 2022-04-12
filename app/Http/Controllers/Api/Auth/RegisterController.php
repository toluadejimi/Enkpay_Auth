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
use Propaganistas\LaravelPhone\PhoneNumber;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends BaseApiController
{

    /**
     * @throws CountryCodeException
     */
    /**
     * @OA\Post(
     *     path="/auth/register",
     *     summary="Register User",
     *     tags={"Register"},
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
     *           name="device_id",
     *           in="query",
     *           required=true,
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
     *   @OA\Response(
     *      response=422,
     *      description="Validation error"
     *   ),
     * )
     */
    public function register(UserRegistrationRequest $request): JsonResponse
    {
        $user = RegisterUserAction::execute($request->validated());

        if ($user->exists) {
            response()->json([
                'success' => true,
                'errors' => null,
                'message' => 'User created successfully.',
                'data' => [
                    'id' => $user->uuid,
                    'name' => $user->full_name,
                    'phone_number' => PhoneNumber::make(
                        $user->phone,
                        $user->phone_country
                    )->formatE164(),
                    'account_type' => $user->type,
                    'pin_status' => $user->pin_status,
                    'account_number' => $user->account_number,
                    'account_balance' => $user->virtual_account_balance,
                    'token_type' => 'Bearer',
                    'token' => $user->createToken('ENKPAY_AUTH')->plainTextToken
                ]
            ])->setStatusCode(
                Response::HTTP_CREATED,
                Response::$statusTexts[Response::HTTP_CREATED]
            );
        }

        return response()->json([
            'success' => true,
            'errors' => true,
            'message' => 'Unable to create user, please try again.',
            'data' => []
        ])->setStatusCode(
            Response::HTTP_OK,
            Response::$statusTexts[Response::HTTP_OK]
        );
    }

    public function verify(TokenVerificationRequest $request): JsonResponse
    {
        $state = VerifyRegisteredAccountAction::execute(
            $request->toArray()
        );

        if ($state) {
            return response()->json([
                'success' => true,
                'errors' => null,
                'message' => 'Account successfully verified.',
                'data' => []
            ])->setStatusCode(
                Response::HTTP_OK,
                Response::$statusTexts[Response::HTTP_OK]
            );
        }

        return response()->json([
            'success' => true,
            'errors' => true,
            'message' => 'Unable to verify account',
            'data' => []
        ])->setStatusCode(
            Response::HTTP_OK,
            Response::$statusTexts[Response::HTTP_OK]
        );
    }
}
