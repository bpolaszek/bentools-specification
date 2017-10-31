<?php

namespace BenTools\Specification\Tests;

use function BenTools\Specification\spec;

class BooleanSpecificationTest extends SpecificationTestCase
{

    public function testTrue()
    {
        $spec = spec(true);
        $this->assertSpecificationFulfilled($spec);
    }

    public function testFalse()
    {
        $spec = spec(false);
        $this->assertSpecificationRejected($spec);
    }
}
