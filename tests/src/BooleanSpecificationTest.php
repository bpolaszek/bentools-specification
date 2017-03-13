<?php

namespace BenTools\Specification\Tests;

use PHPUnit\Framework\TestCase;

use BenTools\Specification\Helper\BooleanSpecification;

class BooleanSpecificationTest extends TestCase
{

    public function testTrue()
    {
        $spec = new BooleanSpecification(true);
        $this->assertTrue($spec());
    }

    public function testFalse()
    {
        $spec = new BooleanSpecification(false);
        $this->assertFalse($spec());
    }

    public function testFunction()
    {
        $this->assertTrue(function_exists('BenTools\\Specification\\Helper\\bool'));
        $spec = \BenTools\Specification\Helper\bool(true);
        $this->assertInstanceOf(BooleanSpecification::class, $spec);
        $this->assertTrue($spec());
        $spec = \BenTools\Specification\Helper\bool(false);
        $this->assertInstanceOf(BooleanSpecification::class, $spec);
        $this->assertFalse($spec());
    }

    public function testOtherwiseCallback()
    {
        $wasCalled = false;
        $otherwise = function () use (&$wasCalled) {
            $wasCalled = true;
        };

        $spec = new BooleanSpecification(true);
        $spec = $spec->otherwise($otherwise);
        $this->assertTrue($spec());
        $this->assertFalse($wasCalled);

        $spec = new BooleanSpecification(false);
        $spec = $spec->otherwise($otherwise);
        $this->assertFalse($spec());
        $this->assertTrue($wasCalled);

    }

}
