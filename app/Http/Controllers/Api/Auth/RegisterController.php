<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\JsonResponse;
use App\Actions\Auth\RegisterUserAction;
use Propaganistas\LaravelPhone\PhoneNumber;
use Symfony\Component\HttpFoundation\Response;
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
        $user = RegisterUserAction::execute($request->validated());

        if ($user->exists) {
            $user->createWallet([
                'name' => 'Naira Wallet',
                'slug' => 'naira_wallet',
            ]);
            $user->createWallet([
                'name' => 'other Wallet',
                'slug' => 'other_wallet',
            ]);
            return response()->json([
                'success' => true,
                'errors' => '',
                'message' => 'User created successfully.',
                'data' => [
                    'id' => $user->uuid,
                    'name' => $user->full_name,
                    'phone_number' => PhoneNumber::make(
                        $user->phone,
                        $user->phone_country
                    )->formatE164(),
                    'default_wallet' => $user->getWallet('naira_wallet'),
                    'other_wallet' => $user->getWallet('other_wallet'),
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
            'success' => false,
            'errors' => 'Unable to create an account.',
            'message' => 'Account registration was not successful, please try again.',
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
                'errors' => '',
                'message' => 'Account successfully verified.',
                'data' => []
            ])->setStatusCode(
                Response::HTTP_OK,
                Response::$statusTexts[Response::HTTP_OK]
            );
        }

        return response()->json([
            'success' => false,
            'errors' => 'Unable to verify account',
            'message' => 'Your account could not be verify, please check your verification token.',
            'data' => []
        ])->setStatusCode(
            Response::HTTP_OK,
            Response::$statusTexts[Response::HTTP_OK]
        );
    }
}
