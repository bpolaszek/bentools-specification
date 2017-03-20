<?php

namespace BenTools\Specification\Logical;

use BenTools\Specification\Specification;
use BenTools\Specification\SpecificationInterface;

class OrSpecification extends Specification
{

    const LEFT_SPEC = 'left';
    const RIGHT_SPEC = 'right';

    /**
     * @var SpecificationInterface
     */
    private $leftSpecification;

    /**
     * @var SpecificationInterface
     */
    private $rightSpecification;

    /**
     * @var string
     */
    private $unmetSpecification;

    /**
     * AndSpecification constructor.
     *
     * @param SpecificationInterface $leftSpecification
     * @param SpecificationInterface $rightSpecification
     */
    public function __construct(SpecificationInterface $leftSpecification, SpecificationInterface $rightSpecification)
    {
        $this->leftSpecification  = $leftSpecification;
        $this->rightSpecification = $rightSpecification;
    }

    /**
     * @inheritDoc
     */
    public function callErrorCallback($cascade = false)
    {
        parent::callErrorCallback();

        if (true === $cascade) {
            if (self::LEFT_SPEC === $this->unmetSpecification) {
                $this->leftSpecification->callErrorCallback($cascade);
            } elseif (self::RIGHT_SPEC === $this->unmetSpecification) {
                $this->rightSpecification->callErrorCallback($cascade);
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function __invoke()
    {
        $leftSpecification = $this->leftSpecification;
        $rightSpecification = $this->rightSpecification;
        if (true !== $leftSpecification()) {
            $this->unmetSpecification = self::LEFT_SPEC;
        } else {
            return true;
        }
        if (true !== $rightSpecification()) {
            if (null === $this->unmetSpecification) {
                $this->unmetSpecification = self::RIGHT_SPEC;
            }
        } else {
            return true;
        }
        return false;
    }
}
