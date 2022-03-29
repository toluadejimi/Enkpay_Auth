<?php

namespace App\Http\Controllers\Api\Transaction;

use Illuminate\Support\Facades\Auth;
use App\Actions\Transaction\GetBanksAction;

class GetBanksController
{
    public function __invoke()
    {
        GetBanksAction::execute(Auth::user());
    }
}
