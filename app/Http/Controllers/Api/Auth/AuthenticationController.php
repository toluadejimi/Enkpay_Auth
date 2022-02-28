<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
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
            $success['token_type'] = 'Bearer';
            $success['token'] =  $user->createToken('ENKPAY_AUTH')->plainTextToken;
            $success = collect($success)->merge(new UserResource($user));


            return $this->sendResponse($success->toArray(), 'User signed in');
        }

        return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
    }

    public function logout(Request $request): Response
    {
        $request->user()->currentAccessToken()->delete();

        return response()->noContent();
    }
}
