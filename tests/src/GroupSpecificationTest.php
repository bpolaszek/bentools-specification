<?php

namespace BenTools\Specification\Tests;

use function BenTools\Specification\spec;

class GroupSpecificationTest extends SpecificationTestCase
{

    public function testGroup()
    {
        $spec = spec(false)->or(true)->asGroup();
        $spec = $spec->or(false);
        $this->assertSpecificationFulfilled($spec);
    }
}
