<?php

namespace BenTools\Specification;

use BenTools\Specification\Logical\AndSpecification;
use BenTools\Specification\Logical\NotSpecification;
use BenTools\Specification\Logical\OrSpecification;

abstract class AbstractSpecification implements SpecificationInterface
{

    /**
     * @inheritdoc
     */
    public function asWellAs(SpecificationInterface $specification): SpecificationInterface
    {
        return new AndSpecification($this, $specification);
    }

    /**
     * @inheritdoc
     */
    public function otherwise(SpecificationInterface $specification): SpecificationInterface
    {
        return new OrSpecification($this, $specification);
    }

    /**
     * @inheritdoc
     */
    public function butNot(SpecificationInterface $specification): SpecificationInterface
    {
        return new AndSpecification($this, new NotSpecification($specification));
    }

}