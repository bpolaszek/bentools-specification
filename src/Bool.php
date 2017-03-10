<?php

namespace BenTools\Specification;

if (!function_exists(sprintf('%s\\bool', __NAMESPACE__))) {
    function bool(bool $bool)
    {
        return new BooleanSpecification($bool);
    }
}