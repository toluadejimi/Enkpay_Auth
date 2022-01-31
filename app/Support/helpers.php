<?php
/** Helpers file */
use App\Support\Generators\Reference;

/** Vulte signature */
if (! function_exists('vulte_signature')) {
    function vulte_signature(string $reference = null): string {
        $secret = vulte_secret();
        $request_ref = $reference ?? (string) Reference::number();

        return md5("{$request_ref};{$secret}");
    }
}

/** Vulte api */
if (! function_exists('vulte_api_key')) {
    function vulte_api_key(): string {
        return config('services.vulte.api_key');
    }
}

/** Vulte secret */
if (! function_exists('vulte_secret')) {
    function vulte_secret(): string {
        return config('services.vulte.secret');
    }
}
