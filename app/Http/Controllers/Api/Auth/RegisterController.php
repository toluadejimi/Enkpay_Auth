<?php

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\RegisterUserAction;
use App\Http\Requests\User\UserRegistrationRequest;

class RegisterController
{
    public function register(UserRegistrationRequest $request)
    {
        $user = RegisterUserAction::execute($request->toArray());

        return $user->exists
            ? response(["message" => "Account created"], 201)
            : "Unable to create user";
    }
}
