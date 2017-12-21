<?php

namespace BenTools\Specification\Logical;

use BenTools\Specification\Exception\UnmetSpecificationException;
use BenTools\Specification\Specification;
use function BenTools\Specification\reject;

final class NotSpecification extends Specification
{
    /**
     * @var Specification
     */
    private $specification;

    /**
     * NotSpecification constructor.
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
        try {
            $innerSpecification->validate();
        } catch (UnmetSpecificationException $e) {
            return;
        }
        reject($this);
    }
}
