<?php

namespace BenTools\Specification\Helper;

use BenTools\Specification\Specification;

if (!function_exists(sprintf('%s\\create', __NAMESPACE__))) {
    function create(...$specifications)
    {
        return new Specification(...$specifications);
    }
}
