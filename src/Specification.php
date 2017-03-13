<?php

namespace BenTools\Specification;

class Specification extends AbstractSpecification
{

    /**
     * @var SpecificationInterface
     */
    private $specification;

    /**
     * Specification constructor.
     * @param SpecificationInterface[] $specifications
     */
    public function __construct(SpecificationInterface ...$specifications)
    {
        if (0 === count($specifications)) {
            $this->specification = new BooleanSpecification(true);
        }
        else {
            $this->specification = array_shift($specifications);
        }

        array_walk($specifications, function (SpecificationInterface $specification) {
            $this->specification = $this->specification->asWellAs($specification);
        });

    }

    public function __invoke(): bool
    {
        $specification = $this->specification;
        return $specification();
    }

    /**
     * @param array ...$specifications
     * @return Specification
     */
    final public static function create(...$specifications)
    {
        return new self(...$specifications);
    }

}
