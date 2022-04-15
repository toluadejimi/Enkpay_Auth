<?php

namespace App\Actions\Transaction;

use App\Models\User;
use Bavix\Wallet\Internal\Exceptions\ExceptionInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Propaganistas\LaravelPhone\Exceptions\CountryCodeException;
use Propaganistas\LaravelPhone\PhoneNumber;

class InternalTransferAction
{
    /**
     * @throws ExceptionInterface
     * @throws CountryCodeException
     */
    public static function execute(array $attributes): Collection
    {//destination_name
        if (! Auth::user()->canTransfer($attributes['amount'])) {
            return self::response("Insufficient fund", false);
        }

        if (Auth::user()->isSuspended()) {
            return self::response("Account is currently suspended", false);
        }

        self::makeTransfer(
            $attributes['phone_number'],
            $attributes['amount']
        );

        return self::response("Transfer was successful");
    }

    /**
     * @throws ExceptionInterface
     * @throws CountryCodeException
     */
    protected static function makeTransfer(string $recipient, int $amount)
    {
        $owner = Auth::user();
        $recipient = User::where('phone', PhoneNumber::make($recipient, 'NG')
            ->formatForCountry('NG'))->first();

        if ($owner->getKey() !== $recipient->getKey()) {
            $owner->transfer($recipient, $amount);
        }
    }

    protected static function response(string $message, bool $state = true): Collection
    {
        return collect([
            'status' => $state,
            'message' => $message
        ]);
    }
}
