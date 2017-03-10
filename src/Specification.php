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
     */
    public function __construct(...$specifications)
    {
        if (0 === count($specifications)) {
            throw new \RuntimeException("At least 1 sepecification must be injected.");
        }

        $specifications = (function (SpecificationInterface ...$specifications) {
            return $specifications;
        })(...$specifications);

        $this->specification = array_shift($specifications);

        array_walk($specifications, function (SpecificationInterface $specification) {
            $this->specification = $this->specification->asWellAs($specification);
        });

    }

    public function __invoke(): bool
    {
        $specification = $this->specification;
        return $specification();
    }

    public function isValid()
    {
        return $this();
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
