<?php

namespace BenTools\Specification\Helper;

use BenTools\Specification\CompositeSpecification;

if (!function_exists(sprintf('%s\\create', __NAMESPACE__))) {
    function create(...$specifications)
    {
        return new CompositeSpecification(...$specifications);
    }
}
