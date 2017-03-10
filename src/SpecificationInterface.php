<?php

namespace BenTools\Specification;

interface SpecificationInterface
{
    /**
     * @param SpecificationInterface $specification
     * @return SpecificationInterface
     */
    public function asWellAs(SpecificationInterface $specification): SpecificationInterface;

    /**
     * @param SpecificationInterface $specification
     * @return SpecificationInterface
     */
    public function otherwise(SpecificationInterface $specification): SpecificationInterface;

    /**
     * @param SpecificationInterface $specification
     * @return SpecificationInterface
     */
    public function butNot(SpecificationInterface $specification): SpecificationInterface;

    /**
     * The specification should return true or false when invoked.
     * @return bool
     */
    public function __invoke(): bool;
}