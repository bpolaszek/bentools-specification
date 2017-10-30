<?php

namespace BenTools\Specification;

use BenTools\Specification\Exception\UnmetSpecificationException;

final class SpecificationExecutor
{
    /**
     * @var Specification
     */
    private $specification;

    /**
     * @var callable
     */
    private $otherwise;

    /**
     * SpecificationReader constructor.
     * @param callable $otherwise
     */
    private function __construct(Specification $specification, callable $otherwise = null)
    {
        $this->specification = $specification;
        $this->otherwise = $otherwise;
    }

    /**
     * @param Specification $specification
     * @return SpecificationExecutor
     */
    public static function isSatisfied(Specification $specification, callable $otherwise = null)
    {
        return new self($specification, $otherwise);
    }

    /**
     * @param callable $otherwise
     */
    public function otherwise(?callable $otherwise)
    {
        $this->otherwise = $otherwise;
        return $this;
    }

    /**
     * @return bool
     */
    public function execute(): bool
    {
        $specification = $this->specification;
        try {
            $specification();
            return true;
        } catch (UnmetSpecificationException $e) {
            if (is_callable($this->otherwise)) {
                $otherwise = $this->otherwise;
                $otherwise(...$e->getUnmetSpecifications());
            }
            return false;
        }
    }

}