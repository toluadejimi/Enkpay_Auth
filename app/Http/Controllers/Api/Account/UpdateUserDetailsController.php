<?php

namespace App\Http\Controllers\Api\Account;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\BaseApiController;
use App\Actions\Account\UpdateUserDetailsAction;
use App\Http\Requests\User\UpdateUserDetailsRequest;

class UpdateUserDetailsController extends BaseApiController
{
    public function __invoke(UpdateUserDetailsRequest $request)
    {
        $state = UpdateUserDetailsAction::execute(Auth::user(), $request->validated());


    }
}
