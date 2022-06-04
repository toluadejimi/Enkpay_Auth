<?php
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpFullyQualifiedNameUsageInspection */

namespace Illuminate\Http {
    
    /**
     * @method array validate(array $rules, ...$params)
     * @method array validateWithBag(string $errorBag, array $rules, ...$params)
     * @method bool hasValidSignature($absolute = true)
     * @method bool hasValidRelativeSignature()
     * @method void transformEnums(array $transformations)
     */
    class Request {}
}

namespace Illuminate\Routing {
    
    /**
     * @method void enum(string $key, string $class)
     */
    class Router {}
}

namespace Illuminate\Validation {

    use Propaganistas\LaravelPhone\Rules\Phone;
    
    /**
     * @method Phone phone()
     */
    class Rule {}
}