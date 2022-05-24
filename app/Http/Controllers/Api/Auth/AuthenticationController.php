<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Propaganistas\LaravelPhone\PhoneNumber;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Api\BaseApiController;
use Propaganistas\LaravelPhone\Exceptions\CountryCodeException;

class AuthenticationController extends BaseApiController
{
    /** @throws CountryCodeException */
    public function login(LoginRequest $request): JsonResponse
    {
        $state = $request->attempt();

        if ($state) {
            $user = Auth::user();

            return response()->json([
                'success' => true,
                'errors' => '',
                'message' => 'User successfully signed in.',
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
                Response::HTTP_OK,
                Response::$statusTexts[Response::HTTP_OK]
            );
        }

        return response()->json([
            'success' => false,
            'errors' => 'Unauthorised access',
            'message' => 'Credentials provided, do not match our existing records.',
            'data' => null
        ])->setStatusCode(
            Response::HTTP_UNAUTHORIZED,
            Response::$statusTexts[Response::HTTP_UNAUTHORIZED]
        );
    }

    public function logout(Request $request)
    {
        Auth::user()->tokens()->delete();

        return response()->json([
            'success' => true,
            'errors' => '',
            'message' => 'Account successfully logout.',
            'data' => null
        ])->setStatusCode(
            Response::HTTP_NO_CONTENT,
            Response::$statusTexts[Response::HTTP_NO_CONTENT]
        );
    }
}
