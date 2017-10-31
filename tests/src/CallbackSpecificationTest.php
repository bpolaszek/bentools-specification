<?php

namespace BenTools\Specification\Tests;

use function BenTools\Specification\spec;

class CallbackSpecificationTest extends SpecificationTestCase
{
    public function testTrue()
    {
        $spec = spec(function () {
            return true;
        });
        $this->assertSpecificationFulfilled($spec);
    }

    public function testFalse()
    {
        $spec = spec(function () {
            return false;
        });
        $this->assertSpecificationRejected($spec);
    }

    /**
     * @expectedException \TypeError
     * @expectedExceptionMessage The result of a callback should be of boolean type.
     */
    public function testInvalidArgument()
    {
        $spec = spec(function () {
            return 'foo';
        });
        $spec();
    }
}
