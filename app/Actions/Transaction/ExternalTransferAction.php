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
            $responseCollection = collect($response['data']['provider_response']);
            return $responseCollection->destination_institution_code;
        }

        activity()->log("{$response['status']}:{$response['data']['error']['message']}");

        return null;

    }
}

/*'provider_response': {
    'destination_institution_code': '076',
      'beneficiary_account_name': 'JAMES BLUE',
      'beneficiary_account_number': '0099880099',
      'beneficiary_kyc_level': '',
      'originator_account_name': '',
      'originator_account_number': '1100009909',
      'originator_kyc_level': '',
      'narration': 'A random transaction',
      'transaction_final_amount': 1000,
      'reference': 'C3DA541CA20740659031949CD3441EBE',
      'payment_id': '382FTTP2005901LD'
    },*/
