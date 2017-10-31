<?php

namespace BenTools\Specification\Helper;

use BenTools\Specification\Specification;
use function BenTools\Specification\reject;

final class BooleanSpecification extends Specification
{
    /**
     * @var bool
     */
    private $bool;

    /**
     * BooleanSpecification constructor.
     *
     * @param bool        $bool
     * @param null|string $name
     */
    protected function __construct(bool $bool, ?string $name)
    {
        $this->bool = $bool;
        $this->label = $name;
    }

    /**
     * @inheritdoc
     */
    public function __invoke(): void
    {
        if (false === $this->bool) {
            reject($this);
        }
    }
}
