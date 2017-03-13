<?php

namespace BenTools\Specification\Logical;

use BenTools\Specification\AbstractSpecification;
use BenTools\Specification\SpecificationInterface;

class OrSpecification extends AbstractSpecification
{

    /**
     * @var SpecificationInterface
     */
    private $specificationA;

    /**
     * @var SpecificationInterface
     */
    private $specificationB;

    /**
     * AndSpecification constructor.
     * @param SpecificationInterface $specificationA
     * @param SpecificationInterface $specificationB
     */
    public function __construct(SpecificationInterface $specificationA, SpecificationInterface $specificationB)
    {
        $this->specificationA = $specificationA;
        $this->specificationB = $specificationB;
    }

    /**
     * @inheritDoc
     */
    public function __invoke(): bool
    {
        $innerSpecificationA = $this->specificationA;
        $innerSpecificationB = $this->specificationB;
        return true === $innerSpecificationA()
            || true === $innerSpecificationB();
    }

}