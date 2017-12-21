<?php

namespace BenTools\Specification;

use BenTools\Specification\Exception\UnmetSpecificationException;
use BenTools\Specification\Helper\BooleanSpecification;
use BenTools\Specification\Helper\CallbackSpecification;
use BenTools\Specification\Logical\AndSpecification;
use BenTools\Specification\Logical\GroupSpecification;
use BenTools\Specification\Logical\NotSpecification;
use BenTools\Specification\Logical\OrSpecification;

abstract class Specification
{
    /**
     * @var string
     */
    protected $label;

    /**
     * @return null|string
     */
    final public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * @param null|string $label
     * @return Specification
     */
    final public function withLabel(?string $label): Specification
    {
        $clone = clone $this;
        $clone->label = $label;
        return $clone;
    }

    /**
     * @param             $specification
     * @param null|string $label
     * @return Specification
     * @throws \RuntimeException
     */
    final public function and($specification, ?string $label = null): Specification
    {
        return new AndSpecification($this, self::factory($specification, $label), $label);
    }

    /**
     * @param             $specification
     * @param null|string $label
     * @return Specification
     * @throws \RuntimeException
     */
    final public function or($specification, ?string $label = null): Specification
    {
        return new OrSpecification($this, self::factory($specification, $label), $label);
    }

    /**
     * @param null|string $label
     * @return Specification
     */
    final public function negate(?string $label = null): Specification
    {
        return new NotSpecification($this, $label);
    }

    /**
     * @param null|string $label
     * @return Specification
     */
    final public function asGroup(?string $label = null): Specification
    {
        return new GroupSpecification($this, $label);
    }

    /**
     * @throws UnmetSpecificationException
     */
    abstract public function validate(): void;

    /**
     * @param             $specification
     * @param null|string $label
     * @return Specification
     * @throws \RuntimeException
     */
    final public static function factory($specification, ?string $label = null): Specification
    {
        if ($specification instanceof Specification) {
            return (null !== $label && $label !== $specification->getLabel()) ? $specification->withLabel($label) : $specification;
        } elseif (is_bool($specification)) {
            return new BooleanSpecification($specification, $label);
        } elseif (is_callable($specification)) {
            return new CallbackSpecification($specification, $label);
        }
        throw new \RuntimeException("Unable to determine specificaton type.");
    }
}
