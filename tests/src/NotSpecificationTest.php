<?php

use BenTools\Specification\BooleanSpecification;
use PHPUnit\Framework\TestCase;

use BenTools\Specification\NotSpecification;

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
        $this->assertTrue(function_exists('BenTools\\Specification\\not'));
        $spec = \BenTools\Specification\not(new BooleanSpecification(true));
        $this->assertInstanceOf(NotSpecification::class, $spec);
    }

}
