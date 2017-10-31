<?php
namespace BenTools\Specification\Tests;

use function BenTools\Specification\not;

class NotSpecificationTest extends SpecificationTestCase
{

    public function testFalseReturnsTrue()
    {
        $spec = not(false);
        $this->assertSpecificationFulfilled($spec);
    }

    public function testTrueReturnsFalse()
    {
        $spec = not(true);
        $this->assertSpecificationRejected($spec);
    }
}
