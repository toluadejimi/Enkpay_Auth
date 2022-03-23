<?php

namespace App\Http\Controllers\Api\Account;

use App\Models\User;

class ActivateAndDeactivateAccountController
{
    public function activate(User $user)
    {
        $user->suspendAccount();
    }

    public function deactivate(User $user)
    {
        $user->revokeAccountSuspension();
    }
}
