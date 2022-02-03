<?php
/** Helpers file */
use Carbon\Carbon;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\Pure;

/** Vulte signature */
if (! function_exists('vulte_signature')) {
    function vulte_signature(string $reference = null): string {
        $secret = vulte_secret();
        $request_ref = $reference ?? reference("TR");

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

/** Application reference generator */
if (! function_exists('reference')) {
    function reference(string $alpha = 'ENKPAY'): string {
        return "{$alpha}|" . Carbon::now()->format('YmdHms') . '|' . mt_rand(10, 99) . substr(time(), 6);
    }
}

/** MD5 of reference string */
if (! function_exists('blind_index')) {
    #[Pure]
    function blind_index(string $reference): string {
        return md5(Str::upper($reference));
    }
}
