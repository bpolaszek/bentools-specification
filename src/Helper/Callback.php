<?php

namespace BenTools\Specification\Helper;

if (!function_exists(sprintf('%s\\callback', __NAMESPACE__))) {
    function callback(callable $callback)
    {
        return new CallbackSpecification($callback);
    }
}
