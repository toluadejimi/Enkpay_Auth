<?php

namespace App\Http\Controllers\Api\Transaction;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Client\RequestException;
use App\Actions\Transaction\ExternalTransferAction;
use App\Http\Requests\Transaction\ExternalTransferRequest;

class ExternalTransferController
{
    /**
     * @throws RequestException
     */
    public function __invoke(ExternalTransferRequest $request)
    {
        $response = ExternalTransferAction::execute(
            Auth::user(),
            $request->validated()
        );
    }
}
