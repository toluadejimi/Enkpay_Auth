<?php

namespace App\Http\Controllers\Api\Account;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Propaganistas\LaravelPhone\PhoneNumber;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{
    public function __invoke()
    {
        $user = Auth::user();

        return response()->json([
            'success' => true,
            'errors' => '',
            'message' => 'Your account profile',
            'data' => [
                'id' => $user->uuid,
                'name' => $user->full_name,
                'phone_number' => PhoneNumber::make(
                    $user->phone,
                    $user->phone_country
                )->formatE164(),
                'account_type' => $user->type,
                'pin_status' => $user->pin_status,
                'account_number' => $user->account_number,
                'account_balance' => $user->virtual_account_balance,
            ]
        ])->setStatusCode(
            Response::HTTP_OK,
            Response::$statusTexts[Response::HTTP_OK]
        );
    }
}
