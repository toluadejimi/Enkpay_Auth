<?php

namespace App\Http\Controllers\Api\Transaction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DTOs\CreditVirtualAccountDto;
use App\Actions\Account\CreditVirtualAccountAction;

class TransactionWebhookController extends Controller
{
    public function __invoke(Request $request)
    {
        //dd($request);

        CreditVirtualAccountAction::execute(
            CreditVirtualAccountDto::fromRequest($request)
        );
    }
}
