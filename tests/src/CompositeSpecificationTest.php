<?php

namespace BenTools\Specification\Tests;

use BenTools\Specification\Helper\BooleanSpecification;
use BenTools\Specification\CompositeSpecification;
use function BenTools\Specification\Helper\create AS spec;
use PHPUnit\Framework\TestCase;

class CompositeSpecificationTest extends TestCase
{

    public function testInit()
    {
        // By function
        $this->assertTrue(function_exists('BenTools\\Specification\\Helper\\create'));
        $spec = spec(new BooleanSpecification(true), new BooleanSpecification(false));
        $this->assertInstanceOf(CompositeSpecification::class, $spec);
        $this->assertFalse($spec());

        // By static method
        $spec = CompositeSpecification::create(new BooleanSpecification(true), new BooleanSpecification(false));
        $this->assertInstanceOf(CompositeSpecification::class, $spec);
        $this->assertFalse($spec());

        // By constructor
        $spec = new CompositeSpecification(new BooleanSpecification(true), new BooleanSpecification(false));
        $this->assertInstanceOf(CompositeSpecification::class, $spec);
        $this->assertFalse($spec());
    }

    public function testANDChaining()
    {
        $spec = new BooleanSpecification(true);

        $spec = $spec->andSuits(new BooleanSpecification(true));
        $this->assertTrue($spec());

        $spec = $spec->andSuits(new BooleanSpecification(false));
        $this->assertFalse($spec());

        $spec = $spec->andSuits(new BooleanSpecification(true));
        $this->assertFalse($spec());
    }

    public function testORChaining()
    {
        $spec = new BooleanSpecification(true);

        $spec = $spec->orSuits(new BooleanSpecification(false));
        $this->assertTrue($spec());

        $spec = $spec->orSuits(new BooleanSpecification(false));
        $this->assertTrue($spec());

        $spec = $spec->orSuits(new BooleanSpecification(true));
        $this->assertTrue($spec());
    }

    public function testANDNOTChaining()
    {
        $spec = new BooleanSpecification(true);
        $spec = $spec->andFails(new BooleanSpecification(false));

        $this->assertTrue($spec());
    }

    public function testORNOTChaining()
    {
        $spec = new BooleanSpecification(false);
        $spec = $spec->orFails(new BooleanSpecification(false));

        $this->assertTrue($spec());
    }


    public function testOtherwiseCallback()
    {
        $wasCalled = false;
        $otherwise = function () use (&$wasCalled) {
            $wasCalled = true;
        };

        $spec = new CompositeSpecification(new BooleanSpecification(true), new BooleanSpecification(true));
        $spec = $spec->otherwise($otherwise);
        $this->assertTrue($spec());
        $this->assertFalse($wasCalled);

        $spec = new CompositeSpecification(new BooleanSpecification(true), new BooleanSpecification(false));
        $spec = $spec->otherwise($otherwise);
        $this->assertFalse($spec());
        $this->assertTrue($wasCalled);

    }


}
