<?php

namespace BenTools\Specification\Logical;

use BenTools\Specification\Exception\UnmetSpecificationException;
use BenTools\Specification\Specification;

final class OrSpecification extends Specification
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
     * OrSpecification constructor.
     *
     * @param Specification $leftSpecification
     * @param Specification $rightSpecification
     * @param null|string   $name
     */
    protected function __construct(
        Specification $leftSpecification,
        Specification $rightSpecification,
        ?string $name
    ) {
    

        $this->leftSpecification = $leftSpecification;
        $this->rightSpecification = $rightSpecification;
        $this->label = $name;
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
        } catch (UnmetSpecificationException $leftException) {
            try {
                $rightSpecification();
            } catch (UnmetSpecificationException $rightException) {
                $rejection = $rejection->withUnmetSpecifications(
                    ...array_merge(
                        [$this],
                        $leftException->getUnmetSpecifications(),
                        $rightException->getUnmetSpecifications()
                    )
                );
                $rejection->throwIfUnmet();
            }
        }
    }
}
