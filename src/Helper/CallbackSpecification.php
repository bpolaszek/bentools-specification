<?php

namespace BenTools\Specification\Helper;

use BenTools\Specification\AbstractSpecification;

class CallbackSpecification extends AbstractSpecification
{
    /**
     * @var callable
     */
    private $callback;

    /**
     * CallbackSpecification constructor.
     * @param callable $callback
     */
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    /**
     * @inheritdoc
     */
    public function __invoke(): bool
    {
        $callback = $this->callback;
        $result = $callback();
        if (!is_bool($result)) {
            throw new \RuntimeException("The result of a callback should be of boolean type.");
        }
        return $result or $this->callErrorCallback();
    }
}
