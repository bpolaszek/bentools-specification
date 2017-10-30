<?php

namespace BenTools\Specification;

use BenTools\Specification\Exception\UnmetSpecificationException;
use BenTools\Specification\Helper\BooleanSpecification;
use BenTools\Specification\Helper\CallbackSpecification;
use BenTools\Specification\Logical\AndSpecification;
use BenTools\Specification\Logical\NotSpecification;
use BenTools\Specification\Logical\OrSpecification;

abstract class Specification
{

    /**
     * @var string
     */
    protected $name;

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function withName(?string $name): Specification
    {
        $clone = clone $this;
        $clone->name = $name;
        return $clone;
    }

    /**
     * @inheritdoc
     */
    public function and(Specification $specification, ?string $name = null): Specification
    {
        return new AndSpecification($this, $specification, $name);
    }

    /**
     * @inheritdoc
     */
    public function or(Specification $specification, ?string $name = null): Specification
    {
        return new OrSpecification($this, $specification, $name);
    }

    /**
     * @return Specification
     */
    public function negate(?string $name = null): Specification
    {
        return new NotSpecification($this, $name);
    }

    /**
     * @throws UnmetSpecificationException
     */
    abstract public function __invoke(): void;

    /**
     * @param mixed $spec
     * @return Specification
     */
    final public static function factory($specification, ?string $name): Specification
    {
        if ($specification instanceof Specification) {
            return $name !== $specification->getName() ? $specification->withName($name) : $specification;
        } elseif (is_callable($specification)) {
            return new CallbackSpecification($specification, $name);
        } elseif (is_bool($specification)) {
            return new BooleanSpecification($specification, $name);
        }
        throw new \RuntimeException("Unable to determine specificaton type.");
    }
}
