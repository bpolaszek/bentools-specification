<?php

namespace BenTools\Specification\Tests;

use BenTools\Specification\BooleanSpecification;
use PHPUnit\Framework\TestCase;

use BenTools\Specification\OrSpecification;

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


}
