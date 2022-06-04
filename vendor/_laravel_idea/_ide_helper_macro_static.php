<?php
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpFullyQualifiedNameUsageInspection */

namespace Illuminate\Http {
    
    /**
     * @method static array validate(array $rules, ...$params)
     * @method static array validateWithBag(string $errorBag, array $rules, ...$params)
     * @method static bool hasValidSignature($absolute = true)
     * @method static bool hasValidRelativeSignature()
     * @method static void transformEnums(array $transformations)
     */
    class Request {}
}

namespace Illuminate\Routing {
    
    /**
     * @method static void enum(string $key, string $class)
     */
    class Router {}
}

namespace Illuminate\Validation {

    use Propaganistas\LaravelPhone\Rules\Phone;
    
    /**
     * @method static Phone phone()
     */
    class Rule {}
}