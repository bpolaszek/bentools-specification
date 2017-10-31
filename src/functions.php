<?php

namespace BenTools\Specification;

use BenTools\Specification\Exception\UnmetSpecificationException;

/**
 * @param $specification
 * @return Specification
 */
function spec($specification, ?string $name = null): Specification
{
    return Specification::factory($specification, $name);
}

/**
 * @param $specification
 * @return Specification
 */
function not($specification, ?string $name = null): Specification
{
    return Specification::factory($specification)->negate($name);
}

/**
 * @param $specification
 * @return Specification
 */
function group($specification, ?string $name = null): Specification
{
    return Specification::factory($specification)->asGroup($name);
}

/**
 * @param Specification[] ...$specifications
 * @throws UnmetSpecificationException
 */
function reject(Specification ...$specifications)
{
    if ([] !== $specifications) {
        UnmetSpecificationException::createFor(...$specifications)->throwIfUnmet();
    }
}
