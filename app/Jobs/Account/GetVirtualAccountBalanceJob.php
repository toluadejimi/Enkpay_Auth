<?php

namespace App\Jobs\Account;

use App\Actions\Account\GetUserAccountBalanceAction;
use App\Actions\Account\UpdateUserAccountWithVirtualAccountBalanceResponse;
use App\Models\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;

class GetVirtualAccountBalanceJob
{
    use Dispatchable;
    use SerializesModels;

    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle()
    {
        $response = retry(3, function () {
            return GetUserAccountBalanceAction::execute($this->user);
        }, 5000);

        UpdateUserAccountWithVirtualAccountBalanceResponse::execute($this->user, $response);
    }
}
