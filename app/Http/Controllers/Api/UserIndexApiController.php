<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Resources\UserResource;

class UserIndexApiController extends BaseApiController
{
    public function __invoke()
    {
        $users = User::all();

        return UserResource::collection($users)->response();
    }
}
