<?php

namespace BenTools\Specification;

interface SpecificationInterface
{
    /**
     * Add a specification that MUST be fulfilled along with this one.
     * @param SpecificationInterface $specification
     * @return SpecificationInterface - Provides fluent interface
     */
    public function andSuits(SpecificationInterface $specification): SpecificationInterface;

    /**
     * Add a specification that MUST be fulfilled if this one's not, and vice-versa.
     * @param SpecificationInterface $specification
     * @return SpecificationInterface - Provides fluent interface
     */
    public function orSuits(SpecificationInterface $specification): SpecificationInterface;

    /**
     * Add a negated-specification that MUST be fulfilled along with this one.
     * @param SpecificationInterface $specification
     * @return SpecificationInterface - Provides fluent interface
     */
    public function andFails(SpecificationInterface $specification): SpecificationInterface;

    /**
     * Specify an optionnal callback that will be called if the condition is not satisfied.
     * @param callable $callback
     * @return $this - Provides fluent interface
     */
    public function otherwise(callable $callback = null): SpecificationInterface;

    /**
     * The specification MUST return true or false when invoked.
     * If the result is false, and a callback has been provided through the otherwise() method,
     * this callback MUST be called by the implementing function.
     * @return bool
     */
    public function __invoke(): bool;
}
