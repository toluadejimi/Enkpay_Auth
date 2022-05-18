<?php

namespace App\Http\Controllers\Api\Account;

use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Actions\Transaction\UserDebitAction;
use App\Actions\Transaction\UserCreditAction;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Transaction\DebitRequest;
use App\Http\Requests\Transaction\CreditRequest;

class TransactionController extends BaseApiController
{
    protected User $user;

    public function posCredit(CreditRequest $request)
    {
        $userCredit = new UserCreditAction();
        $status = $userCredit::execute($request->validated());

        try{
            if ($status) {
                return response()->json([
                    'success' => true,
                    'errors' => '',
                    'message' => 'Account was successfully credited.',
                    'data' => []
                ])->setStatusCode(
                    Response::HTTP_OK,
                    Response::$statusTexts[Response::HTTP_OK]
                );
            }

            return response()->json([
                'success' => false,
                'errors' => 'Failed to credit account.',
                'message' => 'Unable to credit account',
                'data' => []
            ])->setStatusCode(
                Response::HTTP_PRECONDITION_FAILED,
                Response::$statusTexts[Response::HTTP_EXPECTATION_FAILED]
            );
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'errors' => 'Failed to credit account.',
                'message' => 'Unable to credit account',
                'data' => []
            ])->setStatusCode(
                Response::HTTP_PRECONDITION_FAILED,
                Response::$statusTexts[Response::HTTP_EXPECTATION_FAILED]
            );
        }
    }

    public function debit(DebitRequest $request)
    {

        $userDebit = new UserDebitAction();
        $status=  $userDebit->execute($request->validated());

        if ($status) {
            return response()->json([
                'success' => true,
                'errors' => '',
                'message' => 'Account was successfully debited.',
                'data' => Auth::user()
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

    public function reversal(DebitRequest $request)
    {

        $userDebit = new UserDebitAction();
        $status =  $userDebit->reverseAmount($request->validated());

        if ($status) {
            return response()->json([
                'success' => true,
                'errors' => '',
                'message' => 'amount have been reversed to the user',

            ])->setStatusCode(
                Response::HTTP_OK,
                Response::$statusTexts[Response::HTTP_OK]
            );
        }

        return response()->json([
            'success' => false,
            'errors' => 'Failed to credit account.',
            'message' => 'Unable to reverse amount to  account',

        ])->setStatusCode(
            Response::HTTP_UNAUTHORIZED,
            Response::$statusTexts[Response::HTTP_UNAUTHORIZED]
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
