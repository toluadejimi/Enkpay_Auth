<?php

namespace App\Http\Controllers\Api\Transaction;

use App\Actions\Transaction\UpdateTransactionPinAction;
use App\Http\Requests\Transaction\UpdateTransactionPinRequest;

class UpdateTransactionPinController
{
    public function __invoke(UpdateTransactionPinRequest $request)
    {
        $state = UpdateTransactionPinAction::execute(
            $request->validated()
        );

        // return response
    }
}
