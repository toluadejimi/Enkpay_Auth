<?php

namespace App\Actions\Transaction;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use App\Services\Bank\Vulte\Reference;
use Illuminate\Http\Client\RequestException;

class ExternalTransferAction
{
    /**
     * @throws RequestException
     */
    public static function execute(User $user, array $attributes)
    {
        $requestRef = Reference::requestRef();
        $transactionRef = Reference::transactionRef();
        $baseURL = config('services.vulte.base_url').'/v2/transact';

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Signature' => Reference::signature($requestRef)
        ])->withToken(Reference::apiKey())
            ->post($baseURL, [
                'request_ref' => "{$requestRef}",
                'request_type' => 'disburse',
                'auth' => [
                    'type' => null,
                    'secure' => null,
                    'auth_provider' => 'Polaris',
                    'route_mode' => null
                ],
                'transaction' => [
                    'mock_mode' => Reference::mode(),
                    'transaction_ref' => "{$transactionRef}",
                    'transaction_desc' => 'External transfer',
                    'transaction_ref_parent' => null,
                    'amount' => $attributes['amount'],
                    'customer' => [
                        'customer_ref'  => $user->phone_number,
                        'firstname'     => $user->first_name,
                        'surname'       => $user->last_name,
                        'email'         => $user->email,
                        'mobile_no'     => $user->phone_number
                    ],
                    'details' => [
                        'destination_account' => $attributes['destination_account'],
                        'destination_bank_code' => $attributes['destination_bank_code'],
                        'otp_override' => true
                    ]
                ]
            ])->throw()->json();

        if ($response['status'] === 'Successful') {
            activity()->log("{$response['status']}:{$response['message']}");
            return collect($response['data']['provider_response']);
        }

        activity()->log("{$response['status']}:{$response['data']['error']['message']}");

        return null;

    }
}
