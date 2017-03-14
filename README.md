[![Latest Stable Version](https://poser.pugx.org/bentools/specification/v/stable)](https://packagist.org/packages/bentools/specification)
[![License](https://poser.pugx.org/bentools/specification/license)](https://packagist.org/packages/bentools/specification)
[![Build Status](https://scrutinizer-ci.com/g/bpolaszek/bentools-specification/badges/build.png?b=master)](https://scrutinizer-ci.com/g/bpolaszek/bentools-specification/build-status/master)
[![Coverage Status](https://coveralls.io/repos/github/bpolaszek/bentools-specification/badge.svg?branch=master)](https://coveralls.io/github/bpolaszek/bentools-specification?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bpolaszek/bentools-specification/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bpolaszek/bentools-specification/?branch=master)
[![Total Downloads](https://poser.pugx.org/bentools/specification/downloads)](https://packagist.org/packages/bentools/specification)

# bentools/specification

PHP7.0+ implementation of the Specification Pattern.

The goal
--------
The Specification Pattern allows you to wrap some conditionnal structures into value objects. 
This may have no sense in your usual code, but it can be useful when the combination of your business rules 
reaches a high [Cyclomatic Complexity](https://en.wikipedia.org/wiki/Cyclomatic_complexity).

Thus, wrapping your conditions into named objects with a specific failure handling may help you to:
* Add new business rules to existing ones
* Have a better understanding of your conditionnal structures
* Find which condition invalidates the others
* Avoid unreadable lasagna-code

The principles of the Specification Pattern are borrowed from Domain Driven Design, but can be applied anywhere.

Overview
--------
Every `Specification` object implements the [`__invoke()`](http://php.net/manual/en/language.oop5.magic.php#object.invoke) method that **MUST** return a boolean, and can be chained with other specifications.

Here's the contract:

```php
# src/SpecificationInterface.php

namespace BenTools\Specification;

interface SpecificationInterface
{
    /**
     * Add a specification that MUST be fulfilled along with this one.
     * @param SpecificationInterface $specification
     * @return SpecificationInterface - Provides fluent interface
     */
    public function andSuits(SpecificationInterface $specification): SpecificationInterface;

    /**
     * Add a specification that MUST be fulfilled if this one's not, and vice-versa.
     * @param SpecificationInterface $specification
     * @return SpecificationInterface - Provides fluent interface
     */
    public function orSuits(SpecificationInterface $specification): SpecificationInterface;

    /**
     * Add a negated-specification that MUST be fulfilled along with this one.
     * @param SpecificationInterface $specification
     * @return SpecificationInterface - Provides fluent interface
     */
    public function andFails(SpecificationInterface $specification): SpecificationInterface;

    /**
     * Add a negated-specification that MUST be fulfilled if this one's not, and vice-versa.
     * @param SpecificationInterface $specification
     * @return SpecificationInterface - Provides fluent interface
     */
    public function orFails(SpecificationInterface $specification): SpecificationInterface;

    /**
     * Specify an optionnal callback that will be called if the condition is not satisfied.
     * @param callable $callback
     * @return $this - Provides fluent interface
     */
    public function otherwise(callable $callback = null): SpecificationInterface;

    /**
     * The specification MUST return true or false when invoked.
     * If the result is false, and a callback has been provided through the otherwise() method,
     * this callback MUST be called by the implementing function.
     * @return bool
     */
    public function __invoke(): bool;
}
```

If the boolean is false, a callback can be called (provided earlier in the `otherwise()` method).

```php
require_once __DIR__ . '/vendor/autoload.php';

use function BenTools\Specification\Helper\bool as booleanSpec;
use function BenTools\Specification\Helper\callback as callbackSpec;

$condition1 = booleanSpec((bool) random_int(0, 1))->otherwise(function () {
    var_dump('Condition 1 failed.');
});

$condition2 = callbackSpec(function () {
    return (bool) random_int(0, 1);
})->otherwise(function () {
    var_dump('Condition 2 failed.');
});;

$conditions = $condition1->andSuits($condition2);
var_dump($conditions()); // should return true or false, and if false, var_dump() why.
```

Advanced Example
----------------
Since the Specification Pattern is intended to test your business rules, you should better implement your own `Specification` classes.

See our [example](doc/Example.md) to get started.

Installation
------------

PHP 5.6+ (no return types, scalar type hints disabled)

```
composer require bentools/specification ^1.0
```

PHP 7.0+

```
composer require bentools/specification ^2.0
```

License
-------
MIT