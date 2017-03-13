<?php

namespace BenTools\Specification\Helper;

use BenTools\Specification\AbstractSpecification;

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
        $result = $this->bool;
        return $result or $this->callErrorCallback();
    }
}
