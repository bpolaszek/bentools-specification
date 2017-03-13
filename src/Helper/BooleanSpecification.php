<?php

namespace BenTools\Specification\Helper;

use BenTools\Specification\Specification;

class BooleanSpecification extends Specification
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
        $result = $this->bool;
        return $result or $this->callErrorCallback();
    }
}
