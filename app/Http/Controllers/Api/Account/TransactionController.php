<?php

namespace App\Http\Controllers\Api\Account;

use App\Actions\Transaction\UserDebitAction;
use App\Http\Requests\Transaction\DebitRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\BaseApiController;

class TransactionController extends BaseApiController
{
    protected User $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function credit()
    {
        $this->user->credit($amount);
    }

    public function balance()
    {
        $balance = $this->user->balance;

    }

    public function debit(DebitRequest $request)
    {
        UserDebitAction::execute($request->validated());

        //
    }

    public function history()
    {

    }
}
