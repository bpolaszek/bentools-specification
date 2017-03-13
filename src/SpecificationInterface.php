<?php

namespace BenTools\Specification;

interface SpecificationInterface
{
    /**
     * @param SpecificationInterface $specification
     * @return SpecificationInterface - Provides fluent interface
     */
    public function andSuits(SpecificationInterface $specification): SpecificationInterface;

    /**
     * @param SpecificationInterface $specification
     * @return SpecificationInterface - Provides fluent interface
     */
    public function orSuits(SpecificationInterface $specification): SpecificationInterface;

    /**
     * @param SpecificationInterface $specification
     * @return SpecificationInterface - Provides fluent interface
     */
    public function andFails(SpecificationInterface $specification): SpecificationInterface;

    /**
     * Specifies an optionnal callback that will be called if the condition is not satisfied.
     * @param callable $callback
     * @return $this - Provides fluent interface
     */
    public function otherwise(callable $callback = null): SpecificationInterface;

    /**
     * The specification should return true or false when invoked.
     * If the result is false, and a callback has been provided through the otherwise() method,
     * this callback must be called by the implementing function.
     * @return bool
     */
    public function __invoke(): bool;
}
