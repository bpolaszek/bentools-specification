<?php

namespace BenTools\Specification\Tests;

use BenTools\Specification\Helper\BooleanSpecification;
use function BenTools\Specification\spec;
use PHPUnit\Framework\TestCase;

use BenTools\Specification\Logical\AndSpecification;

class AndSpecificationTest extends SpecificationTestCase
{

    public function testAllTrueReturnsTrue()
    {
        $spec = spec(true)->and(true);
        $this->assertSpecificationFulfilled($spec);
    }

    public function testOneFalseReturnsFalse()
    {
        $spec = spec(true)->and(false);
        $this->assertSpecificationRejected($spec);
    }

    public function testAllFalseReturnFalse()
    {
        $spec = spec(false)->and(false);
        $this->assertSpecificationRejected($spec);
    }
}
