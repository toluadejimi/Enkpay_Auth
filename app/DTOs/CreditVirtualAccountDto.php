<?php

namespace App\DTOs;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class CreditVirtualAccountDto
{
    public string $amount;
    protected string $VirtualAccount;

    public function __construct(
        string $VirtualAccount,
        string $amount,
    ){
        $this->amount = $amount;
        $this->VirtualAccount = $VirtualAccount;
    }

    public static function fromRequest($request): static
    {
        return new static(
            $request['amount'],
            $request['data']['VirtualAccount'],
        );
    }

    public function getUserByVirtualAccountNumber(): Builder|User
    {
        return User::query()
            ->where('account_number', $this->VirtualAccount)
            ->first();
    }
}
