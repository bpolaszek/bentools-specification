<?php

namespace BenTools\Specification\Logical;

use BenTools\Specification\Specification;

final class GroupSpecification extends Specification
{
    /**
     * @var Specification
     */
    private $specification;

    /**
     * GroupSpecification constructor.
     *
     * @param Specification $specification
     * @param null|string   $name
     */
    protected function __construct(
        Specification $specification,
        ?string $name
    ) {
    
        $this->specification = $specification;
        $this->label = $name;
    }

    /**
     * @inheritDoc
     */
    public function validate(): void
    {
        $innerSpecification = $this->specification;
        $innerSpecification->validate();
    }
}
