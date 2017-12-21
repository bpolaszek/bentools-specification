<?php

namespace BenTools\Specification\Exception;

use BenTools\Specification\Specification;

class UnmetSpecificationException extends \RuntimeException implements \Countable
{

    /**
     * @var Specification[]
     */
    private $specifications = [];

    /**
     * @inheritDoc
     */
    public function __construct(Specification ...$specifications)
    {
        parent::__construct('Unmet specification.');
        $this->specifications = $specifications;
    }

    /**
     * @param Specification[] ...$specifications
     * @return UnmetSpecificationException
     */
    public static function createFor(Specification ...$specifications): self
    {
        return new self(...$specifications);
    }

    /**
     * @param Specification[] ...$specifications
     * @return UnmetSpecificationException
     */
    public function withUnmetSpecifications(Specification ...$specifications): self
    {
        $clone = new self(...$this->specifications);
        foreach ($specifications as $specification) {
            if (!in_array($specification, $clone->specifications, true)) {
                $clone->specifications[] = $specification;
            }
        }
        return $clone;
    }

    /**
     * @return Specification[]
     */
    public function getUnmetSpecifications(): array
    {
        return $this->specifications;
    }

    /**
     * @throws UnmetSpecificationException
     */
    public function throwIfUnmet()
    {
        if (count($this) > 0) {
            throw $this;
        }
    }

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return count($this->specifications);
    }
}
