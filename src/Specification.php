<?php

namespace BenTools\Specification;

use BenTools\Specification\Logical\AndSpecification;
use BenTools\Specification\Logical\NotSpecification;
use BenTools\Specification\Logical\OrSpecification;

abstract class Specification implements SpecificationInterface
{
    /**
     * @var callable
     */
    protected $onError;

    /**
     * @inheritdoc
     */
    public function andSuits(SpecificationInterface $specification): SpecificationInterface
    {
        return new AndSpecification($this, $specification);
    }

    /**
     * @inheritdoc
     */
    public function orSuits(SpecificationInterface $specification): SpecificationInterface
    {
        return new OrSpecification($this, $specification);
    }

    /**
     * @inheritdoc
     */
    public function andFails(SpecificationInterface $specification): SpecificationInterface
    {
        return new AndSpecification($this, new NotSpecification($specification));
    }

    /**
     * @inheritDoc
     */
    public function orFails(SpecificationInterface $specification): SpecificationInterface
    {
        return new OrSpecification($this, new NotSpecification($specification));
    }

    /**
     * @inheritDoc
     */
    public function otherwise(callable $callback = null): SpecificationInterface
    {
        $this->onError = $callback;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function callErrorCallback()
    {
        if (null !== ($onError = $this->onError)) {
            $onError($this);
        }
    }

    /**
     * @param array ...$args
     * @return SpecificationInterface
     */
    final public static function create(...$args)
    {
        return new static(...$args);
    }
}
