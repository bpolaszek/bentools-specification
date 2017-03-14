<?php

namespace BenTools\Specification\Logical;

use BenTools\Specification\Specification;
use BenTools\Specification\SpecificationInterface;

class NotSpecification extends Specification
{
    /**
     * @var SpecificationInterface
     */
    private $specification;

    /**
     * NotSpecification constructor.
     *
     * @param SpecificationInterface $specification
     */
    public function __construct(SpecificationInterface $specification)
    {
        $this->specification = $specification;
    }

    public function __invoke()
    {
        $innerSpecification = $this->specification;
        return false === $innerSpecification();
    }
}
