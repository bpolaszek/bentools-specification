<?php

use BenTools\Specification\Helper\BooleanSpecification;
use PHPUnit\Framework\TestCase;

use BenTools\Specification\Logical\NotSpecification;

class NotSpecificationTest extends TestCase
{

    public function testTrue()
    {
        $spec = new NotSpecification(new BooleanSpecification(true));
        $this->assertFalse($spec());
    }

    public function testFalse()
    {
        $spec = new NotSpecification(new BooleanSpecification(false));
        $this->assertTrue($spec());
    }

    public function testFunction()
    {
        $this->assertTrue(function_exists('BenTools\\Specification\\Helper\\not'));
        $spec = \BenTools\Specification\Helper\not(new BooleanSpecification(true));
        $this->assertInstanceOf(NotSpecification::class, $spec);
    }

    public function testOtherwiseCallback()
    {
        $wasCalled = false;
        $otherwise = function () use (&$wasCalled) {
            $wasCalled = true;
        };

        $spec = new NotSpecification(new BooleanSpecification(false));
        $spec = $spec->otherwise($otherwise);
        $this->assertTrue($spec());
        $this->assertFalse($wasCalled);

        $spec = new NotSpecification(new BooleanSpecification(true));
        $spec = $spec->otherwise($otherwise);
        $this->assertFalse($spec());
        $this->assertTrue($wasCalled);

    }

}
