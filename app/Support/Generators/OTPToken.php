<?php

namespace App\Support\Generators;

use Exception;
use Illuminate\Support\Facades\DB;

class OTPToken
{
    private static string $otpToken;
    private static string $table = 'phone_verification_tokens';

    private function __construct(
        private string $token,
    )
    {
    }

    public static function generate(): self
    {
        return new self(self::otpToken());
    }

    private static function otpToken(): int|string
    {
        if (empty(self::$otpToken)) {
            do {
                $otpVerificationToken = self::generateToken();
            } while (self::hasUniqueToken($otpVerificationToken));

            self::$otpToken = $otpVerificationToken;
        }

        return self::$otpToken;
    }

    private static function generateToken(): int|string
    {
        $generatedCode = '';

        try {
            $generatedCode = random_int(100000, 999999);
        } catch (Exception $e) {
        }

        return $generatedCode;
    }

    private static function hasUniqueToken(string $token): bool
    {
        return (DB::table(self::$table)
                ->where('token', $token)
                ->count() > 0);
    }

    public function __toString(): string
    {
        return $this->token;
    }
}
