<?php

namespace App\Http\Controllers\Api\Transaction;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Propaganistas\LaravelPhone\PhoneNumber;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Transaction\TransferRequest;
use App\Actions\Transaction\InternalTransferAction;
use Bavix\Wallet\Internal\Exceptions\ExceptionInterface;
use Propaganistas\LaravelPhone\Exceptions\CountryCodeException;

class TransactionTransferController
{
    /**
     * Support single transfer for now
     * @throws ExceptionInterface
     * @throws CountryCodeException
     */
    public function __invoke(TransferRequest $request)
    {
        $state = InternalTransferAction::execute(
            $request->validated()
        );
        try {

            if ($state['status']) {

                return response()->json([
                    'success' => true,
                    'message' =>
                        $state['message'],

                ])->setStatusCode(
                    Response::HTTP_OK,
                    Response::$statusTexts[Response::HTTP_OK]
                );
            }

        } catch
        (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),

            ])->setStatusCode(
                Response::HTTP_PRECONDITION_FAILED,
                Response::$statusTexts[Response::HTTP_EXPECTATION_FAILED]
            );
        }


        return response()->json([
            'success' => false,
            'message' => $state['message'],

        ])->setStatusCode(
            Response::HTTP_PRECONDITION_FAILED,
            Response::$statusTexts[Response::HTTP_PRECONDITION_FAILED]
        );
    }

    /**
     * @throws CountryCodeException
     */
    public function verifyUser(Request $request)
    {
        $phoneNumber = PhoneNumber::make($request->get('phoneNumber'), 'NG')
            ->formatForCountry('NG');

        $user = User::query()
            ->where('phone', $phoneNumber)->get(['middle_name', 'first_name', 'last_name']);

        try {

            return response()->json([
                'success' => true,
                'data' => $user,
                'message' => 'user data fetch successfully',

            ])->setStatusCode(
                Response::HTTP_OK,
                Response::$statusTexts[Response::HTTP_OK]
            );
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),

            ])->setStatusCode(
                Response::HTTP_PRECONDITION_FAILED,
                Response::$statusTexts[Response::HTTP_PRECONDITION_FAILED]
            );
        }
    }
}
