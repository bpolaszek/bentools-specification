<?php

namespace BenTools\Specification;

use BenTools\Specification\Exception\UnmetSpecificationException;

/**
 * @param             $specification
 * @param null|string $name
 * @return Specification
 * @throws \RuntimeException
 */
function spec($specification, ?string $name = null): Specification
{
    return Specification::factory($specification, $name);
}

/**
 * @param             $specification
 * @param null|string $name
 * @return Specification
 * @throws \RuntimeException
 */
function not($specification, ?string $name = null): Specification
{
    return Specification::factory($specification)->negate($name);
}

/**
 * @param             $specification
 * @param null|string $name
 * @return Specification
 * @throws \RuntimeException
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
