<?php

namespace BenTools\Specification;

if (!function_exists(sprintf('%s\\not', __NAMESPACE__))) {
    function not(SpecificationInterface $specification)
    {
        return new NotSpecification($specification);
    }
}