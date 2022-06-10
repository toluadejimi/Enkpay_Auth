<?php

namespace App\DTOs;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class CreditVirtualAccountDto
{
    public function __construct(
        public string $VirtualAccount,
        public string $amount,
    ){}

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
