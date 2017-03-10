<?php

namespace BenTools\Specification\Tests;

use BenTools\Specification\BooleanSpecification;
use BenTools\Specification\Specification;
use function BenTools\Specification\create AS spec;
use PHPUnit\Framework\TestCase;

class SpecificationTest extends TestCase
{

    public function testInit()
    {
        // By function
        $this->assertTrue(function_exists('BenTools\\Specification\\create'));
        $spec = spec(new BooleanSpecification(true), new BooleanSpecification(false));
        $this->assertInstanceOf(Specification::class, $spec);
        $this->assertFalse($spec());

        // By static method
        $spec = Specification::create(new BooleanSpecification(true), new BooleanSpecification(false));
        $this->assertInstanceOf(Specification::class, $spec);
        $this->assertFalse($spec());

        // By constructor
        $spec = new Specification(new BooleanSpecification(true), new BooleanSpecification(false));
        $this->assertInstanceOf(Specification::class, $spec);
        $this->assertFalse($spec());
    }

    public function testANDChaining()
    {
        $spec = new BooleanSpecification(true);

        $spec = $spec->asWellAs(new BooleanSpecification(true));
        $this->assertTrue($spec());

        $spec = $spec->asWellAs(new BooleanSpecification(false));
        $this->assertFalse($spec());

        $spec = $spec->asWellAs(new BooleanSpecification(true));
        $this->assertFalse($spec());
    }

    public function testORChaining()
    {
        $spec = new BooleanSpecification(true);

        $spec = $spec->otherwise(new BooleanSpecification(false));
        $this->assertTrue($spec());

        $spec = $spec->otherwise(new BooleanSpecification(false));
        $this->assertTrue($spec());

        $spec = $spec->otherwise(new BooleanSpecification(true));
        $this->assertTrue($spec());
    }

    public function testNOTChaining()
    {
        $spec = new BooleanSpecification(true);
        $spec = $spec->butNot(new BooleanSpecification(false));

        $this->assertTrue($spec());
    }



}
