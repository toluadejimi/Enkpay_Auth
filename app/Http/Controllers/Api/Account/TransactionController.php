<?php

namespace App\Http\Controllers\Api\Account;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Actions\Transaction\UserDebitAction;
use App\Http\Requests\Transaction\DebitRequest;
use App\Http\Controllers\Api\BaseApiController;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends BaseApiController
{
    protected User $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function credit()
    {
        //$this->user->credit($amount);
    }

    public function debit(DebitRequest $request)
    {
        $status = UserDebitAction::execute($request->validated());

        if ($status) {
            return response()->json([
                'success' => true,
                'errors' => '',
                'message' => 'Account was successfully debited.',
                'data' => []
            ])->setStatusCode(
                Response::HTTP_OK,
                Response::$statusTexts[Response::HTTP_OK]
            );
        }

        return response()->json([
            'success' => false,
            'errors' => 'Failed to debit account.',
            'message' => 'Unable to debit account, due to insufficient funds.',
            'data' => []
        ])->setStatusCode(
            Response::HTTP_OK,
            Response::$statusTexts[Response::HTTP_OK]
        );
    }

    public function history()
    {
        $transactions = Auth::user()->transactions();

        return response()->json([
            'success' => true,
            'errors' => '',
            'message' => 'Transaction history.',
            'data' => collect($transactions)
        ])->setStatusCode(
            Response::HTTP_OK,
            Response::$statusTexts[Response::HTTP_OK]
        );
    }
}
