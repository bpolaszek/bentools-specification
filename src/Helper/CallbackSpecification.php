<?php

namespace BenTools\Specification\Helper;

use BenTools\Specification\Specification;
use function BenTools\Specification\reject;

final class CallbackSpecification extends Specification
{
    /**
     * @var callable
     */
    private $callback;

    /**
     * CallbackSpecification constructor.
     *
     * @param callable    $callback
     * @param null|string $name
     */
    protected function __construct(callable $callback, ?string $name)
    {
        $this->callback = $callback;
        $this->label = $name;
    }

    /**
     * @inheritdoc
     */
    public function validate(): void
    {
        $callback = $this->callback;
        $result = $callback();
        if (!is_bool($result)) {
            throw new \TypeError("The result of a callback should be of boolean type.");
        }
        if (false === $result) {
            reject($this);
        }
    }
}
