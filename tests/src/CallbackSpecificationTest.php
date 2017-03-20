<?php

namespace BenTools\Specification\Tests;

use PHPUnit\Framework\TestCase;

use BenTools\Specification\Helper\CallbackSpecification;

class CallbackSpecificationTest extends TestCase
{

    public function testTrue()
    {
        $spec = new CallbackSpecification(function () {
            return true;
        });
        $this->assertTrue($spec());
    }

    public function testFalse()
    {
        $spec = new CallbackSpecification(function () {
            return false;
        });
        $this->assertFalse($spec());
    }

    public function testFunction()
    {
        $this->assertTrue(function_exists('BenTools\\Specification\\Helper\\callback'));
        $spec = \BenTools\Specification\Helper\callback(function () {
            return true;
        });
        $this->assertInstanceOf(CallbackSpecification::class, $spec);
        $this->assertTrue($spec());
        $spec = \BenTools\Specification\Helper\callback(function () {
            return false;
        });
        $this->assertInstanceOf(CallbackSpecification::class, $spec);
        $this->assertFalse($spec());
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testInvalidBoolean()
    {
        $spec = new CallbackSpecification(function () {
            return 'foo';
        });
        $spec();
    }

    /*public function testOtherwiseCallback()
    {
        $wasCalled = false;
        $otherwise = function () use (&$wasCalled) {
            $wasCalled = true;
        };

        $spec = new CallbackSpecification(function () {
            return true;
        });
        $spec = $spec->otherwise($otherwise);
        $this->assertTrue($spec());
        $this->assertFalse($wasCalled);

        $spec = new CallbackSpecification(function () {
            return false;
        });
        $spec = $spec->otherwise($otherwise);
        $this->assertFalse($spec());
        $this->assertTrue($wasCalled);

    }*/

}
