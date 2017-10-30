<?php

namespace BenTools\Specification\Logical;

use BenTools\Specification\Exception\UnmetSpecificationException;
use BenTools\Specification\Specification;

final class AndSpecification extends Specification
{

    /**
     * @var Specification
     */
    private $leftSpecification;

    /**
     * @var Specification
     */
    private $rightSpecification;


    /**
     * AndSpecification constructor.
     *
     * @param Specification $leftSpecification
     * @param Specification $rightSpecification
     * @param null|string   $name
     */
    protected function __construct(
        Specification $leftSpecification,
        Specification $rightSpecification,
        ?string $name
    )
    {
        $this->leftSpecification = $leftSpecification;
        $this->rightSpecification = $rightSpecification;
        $this->name = $name;
    }

    /**
     * @inheritDoc
     */
    public function __invoke(): void
    {
        $rejection = new UnmetSpecificationException();
        $leftSpecification = $this->leftSpecification;
        $rightSpecification = $this->rightSpecification;

        try {
            $leftSpecification();
        } catch (UnmetSpecificationException $e) {
            $rejection = $rejection->withUnmetSpecifications($this)
                ->withUnmetSpecifications(
                    ...$e->getUnmetSpecifications()
                );
        }

        try {
            $rightSpecification();
        } catch (UnmetSpecificationException $e) {
            $rejection = $rejection->withUnmetSpecifications($this)
                ->withUnmetSpecifications(
                    ...$e->getUnmetSpecifications()
                );
        }

        $rejection->throwIfUnmet();
    }
}
