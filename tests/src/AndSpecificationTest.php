<?php

namespace BenTools\Specification\Tests;

use BenTools\Specification\Helper\BooleanSpecification;
use PHPUnit\Framework\TestCase;

use BenTools\Specification\Logical\AndSpecification;

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

    public function testOtherwiseCallback()
    {
        $wasCalled = false;
        $otherwise = function () use (&$wasCalled) {
            $wasCalled = true;
        };

        $spec = new AndSpecification(new BooleanSpecification(true), new BooleanSpecification(true));
        $spec = $spec->otherwise($otherwise);
        $this->assertTrue($spec());
        $this->assertFalse($wasCalled);

        $spec = new AndSpecification(new BooleanSpecification(false), new BooleanSpecification(false));
        $spec = $spec->otherwise($otherwise);
        $this->assertFalse($spec());
        $this->assertTrue($wasCalled);

    }

}
