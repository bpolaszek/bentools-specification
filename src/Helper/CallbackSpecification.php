<?php

namespace BenTools\Specification\Helper;

use function BenTools\Specification\reject;
use BenTools\Specification\Specification;

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
    public function __invoke(): void
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
