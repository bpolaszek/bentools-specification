<?php

namespace BenTools\Specification\Tests;

use BenTools\Specification\BooleanSpecification;
use PHPUnit\Framework\TestCase;

use BenTools\Specification\AndSpecification;

class AndSpecificationTest extends TestCase
{

    public function testAllTrueReturnsTrue()
    {
        $spec = new AndSpecification(new BooleanSpecification(true), new BooleanSpecification(true));
        $this->assertTrue($spec());
    }

    public function testOneFalseReturnsFalse()
    {
        $spec = new AndSpecification(new BooleanSpecification(false), new BooleanSpecification(true));
        $this->assertFalse($spec());
        $spec = new AndSpecification(new BooleanSpecification(true), new BooleanSpecification(false));
        $this->assertFalse($spec());
    }

    public function testAllFalseReturnFalse()
    {
        $spec = new AndSpecification(new BooleanSpecification(false), new BooleanSpecification(false));
        $this->assertFalse($spec());
    }

}
