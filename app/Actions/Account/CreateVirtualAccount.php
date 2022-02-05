<?php

namespace App\Actions\Account;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class CreateVirtualAccount
{
    protected static mixed $response;

    /**
     * @throws RequestException
     */
    public static function execute(User $user)
    {
        $requestRef = reference('RQ');
        $transactionRef = reference('TR');
        $baseURL = config('services.vulte.base_url').'/v2/transact';

        return Http::withHeaders([
            'Content-Type' => 'application/json',
            'Signature' => vulte_signature($requestRef)
        ])->withToken(vulte_api_key())
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
                    'mock_mode' => 'Live',
                    'transaction_ref' => "{$transactionRef}",
                    'transaction_desc' => 'A random transaction',
                    'transaction_ref_parent' => null,
                    'amount' => 1000,
                    'customer' => [
                        'customer_ref' => '2348033000989',
                        'firstname' => $user->first_name,
                        'surname' => $user->last_name,
                        'email' => 'john@doe.com',
                        'mobile_no' => $user->phone_number
                    ],
                    'meta' => [
                        'a_key' => 'a_meta_value_1',
                        'b_key' => 'a_meta_value_2'
                    ],
                    'details' => [
                        'name_on_account' => $user->full_name,
                        'middlename' => $user->middle_name,
                        'dob' => '2005-05-13',
                        'gender' => 'M',
                        'title' => 'Mr',
                        'address_line_1' => '23, Okon street, Ikeja',
                        'address_line_2' => 'Ikeja',
                        'city' => 'Mushin',
                        'state' => 'Lagos State',
                        'country' => 'Nigeria'
                    ]
                ]
            ])->throw()->json();
    }
}
