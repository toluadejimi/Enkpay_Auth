<?php

namespace App\Support\Generators;

use Exception;
use Illuminate\Support\Facades\DB;

class PasswordResetToken
{
    private static string $passwordResetToken;
    private static string $table = 'password_resets';

    private function __construct(
        private string $token,
    )
    {
    }

    public static function generate(): self
    {
        return new self(self::resetToken());
    }

    private static function resetToken(): int|string
    {
        if (empty(self::$passwordResetToken)) {
            do {
                $passwordResetToken = self::generateResetToken();
            } while (self::hasUniqueResetToken($passwordResetToken));

            self::$passwordResetToken = $passwordResetToken;
        }

        return self::$passwordResetToken;
    }

    private static function generateResetToken(): int|string
    {
        $generatedCode = '';

        try {
            $generatedCode = random_int(100000, 999999);
        } catch (Exception $e) {
        }

        return $generatedCode;
    }

    private static function hasUniqueResetToken(string $resetCode): bool
    {
        return (count(DB::table(self::$table)
                ->where('token', $resetCode)
                ->get()) > 0);
    }

    public function __toString(): string
    {
        return $this->token;
    }
}
