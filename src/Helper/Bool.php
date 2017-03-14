<?php

namespace BenTools\Specification\Helper;

if (!function_exists(sprintf('%s\\bool', __NAMESPACE__))) {
    function bool($bool)
    {
        return new BooleanSpecification($bool);
    }
}
