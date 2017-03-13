<?php

namespace BenTools\Specification\Helper;

use BenTools\Specification\Logical\NotSpecification;
use BenTools\Specification\SpecificationInterface;

if (!function_exists(sprintf('%s\\not', __NAMESPACE__))) {
    function not(SpecificationInterface $specification)
    {
        return new NotSpecification($specification);
    }
}