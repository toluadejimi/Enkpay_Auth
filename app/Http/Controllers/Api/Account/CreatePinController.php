<?php

namespace App\Http\Controllers\Api\Account;

use App\Http\Requests\CreatePinRequest;
use App\Actions\Account\CreatePinAction;

class CreatePinController
{
    public function __invoke(CreatePinRequest $request)
    {
        $state = CreatePinAction::execute($request->toArray());

        //return
    }
}
