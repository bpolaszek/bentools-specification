<?php

namespace BenTools\Specification;

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