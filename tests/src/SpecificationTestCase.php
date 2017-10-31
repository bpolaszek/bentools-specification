<?php

namespace BenTools\Specification\Tests;

use BenTools\Specification\Exception\UnmetSpecificationException;
use BenTools\Specification\Specification;
use PHPUnit\Framework\TestCase;

class SpecificationTestCase extends TestCase
{
    /**
     * @param Specification $specification
     * @param string        $message
     */
    protected function assertSpecificationFulfilled(Specification $specification, $message = '')
    {
        $unmetSpecifications = [];
        try {
            $specification();
        } catch (UnmetSpecificationException $exception) {
            $unmetSpecifications = $exception->getUnmetSpecifications();
        }
        $this->assertCount(0, $unmetSpecifications);
    }
    /**
     * @param Specification $specification
     * @param string        $message
     */
    protected function assertSpecificationRejected(Specification $specification, $message = '')
    {
        $unmetSpecifications = [];
        try {
            $specification();
        } catch (UnmetSpecificationException $exception) {
            $unmetSpecifications = $exception->getUnmetSpecifications();
        }
        $this->assertNotCount(0, $unmetSpecifications);
    }
}
