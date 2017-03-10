<?php

namespace BenTools\Specification;

class BooleanSpecification extends AbstractSpecification
{
    /**
     * @var bool
     */
    private $bool;

    /**
     * BooleanSpecification constructor.
     * @param bool $bool
     */
    public function __construct(bool $bool)
    {
        $this->bool = $bool;
    }

    /**
     * @inheritdoc
     */
    public function __invoke(): bool
    {
        return $this->bool;
    }
}