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
    return Specification::factory($specification, null)->negate($name);
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

/**
 * @param Specification $specification
 * @param callable|null $otherwise
 * @return SpecificationExecutor
 */
function validate(Specification $specification, callable $otherwise = null)
{
    return SpecificationExecutor::isSatisfied($specification)->otherwise($otherwise);
}