<?php

namespace App\Http\Controllers\Api\Auth;

use App\States\User\Active;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Propaganistas\LaravelPhone\PhoneNumber;
use App\Http\Controllers\Api\BaseApiController;

class AuthenticationController extends BaseApiController
{
    public function login(Request $request): JsonResponse
    {
        $state = Auth::attempt([
            'phone' => PhoneNumber::make($request->phone, 'NG')->formatInternational(),
            'password' => $request->password,
            function ($builder) {
                $builder->whereState('status', Active::class);
            }
        ]);

        if ($state) {
            $success['user'] = $user = new UserResource(Auth::user());
            $success['token_type'] = 'Bearer';
            $success['token'] =  $user->createToken('ENKPAY_AUTH')->plainTextToken;

            return $this->sendResponse($success, 'User signed in');
        }

        return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
    }

    public function logout(Request $request): Response
    {
        $request->user()->currentAccessToken()->delete();

        return response()->noContent();
    }
}
