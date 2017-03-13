<?php

namespace BenTools\Specification\Tests;

use BenTools\Specification\Helper\BooleanSpecification;
use PHPUnit\Framework\TestCase;

use BenTools\Specification\Logical\OrSpecification;

class OrSpecificationTest extends TestCase
{

    public function testAllTrueReturnsTrue()
    {
        $spec = new OrSpecification(new BooleanSpecification(true), new BooleanSpecification(true));
        $this->assertTrue($spec());
    }

    public function testOneFalseReturnsTrue()
    {
        $spec = new OrSpecification(new BooleanSpecification(false), new BooleanSpecification(true));
        $this->assertTrue($spec());
        $spec = new OrSpecification(new BooleanSpecification(true), new BooleanSpecification(false));
        $this->assertTrue($spec());
    }

    public function testAllFalseReturnFalse()
    {
        $spec = new OrSpecification(new BooleanSpecification(false), new BooleanSpecification(false));
        $this->assertFalse($spec());
    }

    public function testOtherwiseCallback()
    {
        $wasCalled = false;
        $otherwise = function () use (&$wasCalled) {
            $wasCalled = true;
        };

        $spec = new OrSpecification(new BooleanSpecification(true), new BooleanSpecification(true));
        $spec = $spec->otherwise($otherwise);
        $this->assertTrue($spec());
        $this->assertFalse($wasCalled);

        $spec = new OrSpecification(new BooleanSpecification(false), new BooleanSpecification(false));
        $spec = $spec->otherwise($otherwise);
        $this->assertFalse($spec());
        $this->assertTrue($wasCalled);

    }


}
