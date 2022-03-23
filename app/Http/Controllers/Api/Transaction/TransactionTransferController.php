<?php

namespace App\Http\Controllers\Api\Transaction;

use App\Http\Requests\Transaction\TransferRequest;
use App\Actions\Transaction\InternalTransferAction;
use Bavix\Wallet\Internal\Exceptions\ExceptionInterface;
use Propaganistas\LaravelPhone\Exceptions\CountryCodeException;

class TransactionTransferController
{
    /**
     * Support single transfer for now
     * @throws ExceptionInterface
     * @throws CountryCodeException
     */
    public function __invoke(TransferRequest $request)
    {
        $state = InternalTransferAction::execute(
            $request->validated()
        );

        if ($state->status) {
            //
        }
    }
}
