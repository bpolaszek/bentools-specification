<?php

namespace BenTools\Specification;

use BenTools\Specification\Helper\BooleanSpecification;

final class CompositeSpecification extends Specification
{

    /**
     * @var SpecificationInterface
     */
    private $specification;

    /**
     * CompositeSpecification constructor.
     * @param SpecificationInterface[] $specifications
     */
    public function __construct(SpecificationInterface ...$specifications)
    {
        if (0 === count($specifications)) {
            $this->specification = new BooleanSpecification(true);
        } else {
            $this->specification = array_shift($specifications);
        }

        array_walk($specifications, function (SpecificationInterface $specification) {
            $this->specification = $this->specification->andSuits($specification);
        });
    }

    public function __invoke(): bool
    {
        $specification = $this->specification;
        $result        = $specification();
        return $result or $this->callErrorCallback();
    }

}
