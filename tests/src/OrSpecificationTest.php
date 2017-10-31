<?php

namespace BenTools\Specification\Tests;

use function BenTools\Specification\spec;

class OrSpecificationTest extends SpecificationTestCase
{

    public function testAllTrueReturnsTrue()
    {
        $spec = spec(true)->or(true);
        $this->assertSpecificationFulfilled($spec);
    }

    public function testOneFalseReturnsTrue()
    {
        $spec = spec(true)->or(false);
        $this->assertSpecificationFulfilled($spec);

        $spec = spec(false)->or(true);
        $this->assertSpecificationFulfilled($spec);
    }

    public function testAllFalseReturnsFalse()
    {
        $spec = spec(false)->or(false);
        $this->assertSpecificationRejected($spec);
    }
}
