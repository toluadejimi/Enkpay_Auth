<?php

namespace App\Actions\Account;

use App\DTOs\CreditVirtualAccountDto;

class CreditVirtualAccountAction
{
    public static function execute(CreditVirtualAccountDto $request): void
    {
        $request->getUserByVirtualAccountNumber()
            ->credit($request->amount);
    }
}
