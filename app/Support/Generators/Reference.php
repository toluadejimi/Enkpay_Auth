<?php

namespace App\Support\Generators;

use Carbon\Carbon;

class Reference
{
    protected static string $ref;

    private function __construct(
        private string $number
    ){
    }

    public static function number(string $alpha = 'ENKPAY'): string
    {
        static::$ref = "{$alpha}|".Carbon::now()->format('YmdHms')."|".mt_rand(10, 99).substr(time(), 6);

        return (string) new self(static::$ref);
    }

    public function __toString(): string
    {
        return $this->number;
    }
}
