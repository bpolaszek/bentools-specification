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

    public function testOtherwiseCallbackWhenTrue()
    {
        $callbackStorage = new \ArrayObject([
            'composite' => false,
            'left' => false,
            'right' => false,
        ]);

        $leftSpec = new BooleanSpecification(true);
        $leftSpec->otherwise(function () use ($callbackStorage) {
            $callbackStorage['left'] = true;
        });

        $rightSpec = new BooleanSpecification(true);
        $rightSpec->otherwise(function () use ($callbackStorage) {
            $callbackStorage['right'] = true;
        });


        $spec      = new OrSpecification($leftSpec, $rightSpec);
        $spec      = $spec->otherwise(function () use ($callbackStorage) {
            $callbackStorage['composite'] = true;
        });

        if (false === ($result = $spec())) {
            $spec->callErrorCallback();
        }
        $this->assertTrue($result);
        $this->assertFalse($callbackStorage['composite']);
        $this->assertFalse($callbackStorage['left']);
        $this->assertFalse($callbackStorage['right']);

    }

    public function testOtherwiseCallbackWhenAllIsFalse()
    {
        $callbackStorage = new \ArrayObject([
            'composite' => false,
            'left' => false,
            'right' => false,
        ]);

        $leftSpec = new BooleanSpecification(false);
        $leftSpec->otherwise(function () use ($callbackStorage) {
            $callbackStorage['left'] = true;
        });

        $rightSpec = new BooleanSpecification(false);
        $rightSpec->otherwise(function () use ($callbackStorage) {
            $callbackStorage['right'] = true;
        });


        $spec      = new OrSpecification($leftSpec, $rightSpec);
        $spec      = $spec->otherwise(function () use ($callbackStorage) {
            $callbackStorage['composite'] = true;
        });

        if (false === ($result = $spec())) {
            $spec->callErrorCallback();
        }
        $this->assertFalse($result);
        $this->assertTrue($callbackStorage['composite']);
        $this->assertFalse($callbackStorage['left']);
        $this->assertFalse($callbackStorage['right']);

        // Test cascading
        if (false === ($result = $spec())) {
            $spec->callErrorCallback(true);
        }
        $this->assertTrue($callbackStorage['composite']);
        $this->assertTrue($callbackStorage['left']);
        $this->assertFalse($callbackStorage['right']); // The left condition failed, thus the right one is not resolved.
    }


    public function testOtherwiseCallbackWhenLeftIsTrue()
    {
        $callbackStorage = new \ArrayObject([
            'composite' => false,
            'left' => false,
            'right' => false,
        ]);

        $leftSpec = new BooleanSpecification(true);
        $leftSpec->otherwise(function () use ($callbackStorage) {
            $callbackStorage['left'] = true;
        });

        $rightSpec = new BooleanSpecification(false);
        $rightSpec->otherwise(function () use ($callbackStorage) {
            $callbackStorage['right'] = true;
        });


        $spec      = new OrSpecification($leftSpec, $rightSpec);
        $spec      = $spec->otherwise(function () use ($callbackStorage) {
            $callbackStorage['composite'] = true;
        });

        if (false === ($result = $spec())) {
            $spec->callErrorCallback();
        }
        $this->assertTrue($result); // Because the left condition resolves to true
        $this->assertFalse($callbackStorage['composite']); // Because the whole condition resolves to true
        $this->assertFalse($callbackStorage['left']); // Because the whole condition resolves to true
        $this->assertFalse($callbackStorage['right']); // Because the whole condition resolves to true

        // Test cascading
        if (false === ($result = $spec())) {
            $spec->callErrorCallback(true);
        }
        $this->assertFalse($callbackStorage['composite']); // Because the whole condition resolves to true
        $this->assertFalse($callbackStorage['left']); // Because the whole condition resolves to true
        $this->assertFalse($callbackStorage['right']); // Because the whole condition resolves to true
    }


    public function testOtherwiseCallbackWhenRightIsTrue()
    {
        $callbackStorage = new \ArrayObject([
            'composite' => false,
            'left' => false,
            'right' => false,
        ]);

        $leftSpec = new BooleanSpecification(false);
        $leftSpec->otherwise(function () use ($callbackStorage) {
            $callbackStorage['left'] = true;
        });

        $rightSpec = new BooleanSpecification(true);
        $rightSpec->otherwise(function () use ($callbackStorage) {
            $callbackStorage['right'] = true;
        });


        $spec      = new OrSpecification($leftSpec, $rightSpec);
        $spec      = $spec->otherwise(function () use ($callbackStorage) {
            $callbackStorage['composite'] = true;
        });

        if (false === ($result = $spec())) {
            $spec->callErrorCallback();
        }
        $this->assertTrue($result); // Because the left condition resolves to true
        $this->assertFalse($callbackStorage['composite']); // Because the whole condition resolves to true
        $this->assertFalse($callbackStorage['left']); // Because the whole condition resolves to true
        $this->assertFalse($callbackStorage['right']); // Because the whole condition resolves to true

        // Test cascading
        if (false === ($result = $spec())) {
            $spec->callErrorCallback(true);
        }
        $this->assertFalse($callbackStorage['composite']); // Because the whole condition resolves to true
        $this->assertFalse($callbackStorage['left']); // Because the whole condition resolves to true
        $this->assertFalse($callbackStorage['right']); // Because the whole condition resolves to true
    }



}
