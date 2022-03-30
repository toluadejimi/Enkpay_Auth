<?php

namespace App\Http\Controllers\Api\Transaction;

use App\Actions\Transaction\ExternalTransferAction;
use App\Http\Requests\Transaction\ExternalTranferRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Auth;

class ExternalTransferController
{
    /**
     * @throws RequestException
     */
    public function __invoke(ExternalTranferRequest $request)
    {
        $response = ExternalTransferAction::execute(
            Auth::user(),
            $request->validated()
        );
    }
}
