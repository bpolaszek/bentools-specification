<?php

namespace BenTools\Specification\Logical;

use BenTools\Specification\Exception\UnmetSpecificationException;
use function BenTools\Specification\reject;
use BenTools\Specification\Specification;

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
    )
    {
        $this->specification = $specification;
        $this->name = $name;
    }

    /**
     * @inheritDoc
     */
    public function __invoke(): void
    {
        $innerSpecification = $this->specification;
        try {
            $innerSpecification();
        } catch (UnmetSpecificationException $e) {
            return;
        }
        reject($this);
    }
}
