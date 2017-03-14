<?php

namespace BenTools\Specification;

use BenTools\Specification\Logical\AndSpecification;
use BenTools\Specification\Logical\OrSpecification;

interface SpecificationInterface
{
    /**
     * Add a specification that MUST be fulfilled along with this one.
     *
     * @param  SpecificationInterface $specification
     * @return SpecificationInterface|AndSpecification - Provides fluent interface
     */
    public function andSuits(SpecificationInterface $specification);

    /**
     * Add a specification that MUST be fulfilled if this one's not, and vice-versa.
     *
     * @param  SpecificationInterface $specification
     * @return SpecificationInterface|OrSpecification - Provides fluent interface
     */
    public function orSuits(SpecificationInterface $specification);

    /**
     * Add a negated-specification that MUST be fulfilled along with this one.
     *
     * @param  SpecificationInterface $specification
     * @return SpecificationInterface|AndSpecification - Provides fluent interface
     */
    public function andFails(SpecificationInterface $specification);

    /**
     * Add a negated-specification that MUST be fulfilled if this one's not, and vice-versa.
     *
     * @param  SpecificationInterface $specification
     * @return SpecificationInterface|OrSpecification - Provides fluent interface
     */
    public function orFails(SpecificationInterface $specification);

    /**
     * Specify an optionnal callback that should be called if the condition is not satisfied.
     *
     * @param  callable $callback
     * @return $this - Provides fluent interface
     */
    public function otherwise(callable $callback = null);

    /**
     * Calls the callback provided by otherwise()
     */
    public function callErrorCallback(): void;

    /**
     * The specification MUST return true or false when invoked.
     *
     * @return bool
     */
    public function __invoke();
}
