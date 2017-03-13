<?php

namespace BenTools\Specification\Helper;

use BenTools\Specification\Helper\CallbackSpecification;

if (!function_exists(sprintf('%s\\callback', __NAMESPACE__))) {
    function callback(callable $callback)
    {
        return new CallbackSpecification($callback);
    }
}