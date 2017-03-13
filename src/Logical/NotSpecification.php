<?php

namespace BenTools\Specification\Logical;

use BenTools\Specification\AbstractSpecification;
use BenTools\Specification\SpecificationInterface;

class NotSpecification extends AbstractSpecification
{
    /**
     * @var SpecificationInterface
     */
    private $specification;

    /**
     * NotSpecification constructor.
     * @param SpecificationInterface $specification
     */
    public function __construct(SpecificationInterface $specification)
    {
        $this->specification = $specification;
    }

    public function __invoke(): bool
    {
        $innerSpecification = $this->specification;
        return !$innerSpecification();
    }
}