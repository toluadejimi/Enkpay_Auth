<?php

namespace App\Http\Controllers\Api\Transaction;

use App\Actions\Transaction\ExternalTransferAction;
use App\Http\Requests\Transaction\ExternalTranferRequest;

class ExternalTransferController
{
    public function __invoke(ExternalTranferRequest $request)
    {
        ExternalTransferAction::execute(
            $request->validated()
        );
    }
}
