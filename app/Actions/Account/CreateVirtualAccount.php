<?php

namespace App\Actions\Account;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use App\Services\Bank\Vulte\Reference;
use Illuminate\Http\Client\RequestException;

class CreateVirtualAccount
{
    protected static mixed $response;

    /**
     * @throws RequestException
     */
    public static function execute(User $user)
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
                'request_type' => 'open_account',
                'auth' => [
                    'type' => null,
                    'secure' => null,
                    'auth_provider' => 'Polaris',
                    'route_mode' => null
                ],
                'transaction' => [
                    'mock_mode' => Reference::mode(),
                    'transaction_ref' => "{$transactionRef}",
                    'transaction_desc' => "Virtual Account Opening",
                    'transaction_ref_parent' => null,
                    'customer' => [
                        'customer_ref'  => $user->phone_number,
                        'firstname'     => $user->first_name,
                        'surname'       => $user->last_name,
                        'email'         => $user->email,
                        'mobile_no'     => $user->phone_number
                    ]
                ]
            ])->throw()->json();

        if ($response['status'] === "Successful") {
            activity()->log("{$response['status']}:{$response['message']}");
            return $response['data']['provider_response']['account_number'];
        }

        activity()->log("{$response['status']}:{$response['data']['error']['message']}");

        return null;
    }
}
